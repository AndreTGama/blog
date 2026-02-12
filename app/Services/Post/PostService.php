<?php

namespace App\Services\Post;

use App\DataTransferObjects\Common\IndexDTO;
use App\DataTransferObjects\Post\Request\StorePostDTO;
use App\Models\Post;
use App\Supports\SlugGenerator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(private SlugGenerator $slugGenerator) {}

    /**
     * Retrieve a paginated list of posts based on the provided filters and pagination parameters.
     *
     * @param IndexDTO $dto The data transfer object containing filters and pagination parameters.
     * @return LengthAwarePaginator A paginated collection of posts matching the criteria.
     */
    public function index(IndexDTO $dto): LengthAwarePaginator
    {
        $query = Post::query();

        if (!empty($dto->filters['search'])) {
            $searchTerm = $dto->filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('slug', 'like', "%{$searchTerm}%")
                    ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhereHas('author', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $query->orderBy($dto->orderBy, $dto->orderDirection);
        $query->with(['author', 'categories', 'postMetas']);
        return $query->paginate($dto->limit, ['*'], 'page', $dto->page);
    }

    /**
     * Store a new post in the database based on the provided data transfer object.
     *
     * @param StorePostDTO $dto The data transfer object containing the details of the post to be created.
     * @return Post The newly created post instance.
     */
    public function store(StorePostDTO $dto): Post
    {
        $post = new Post();
        $post->cover_image = $dto->coverImage;
        $post->title = $dto->title;
        $post->slug = $this->slugGenerator->generateUnique($dto->title, 'posts');
        $post->excerpt = $dto->excerpt;
        $post->content = $dto->content;
        $post->status = $dto->status;
        $post->author_id = auth()->id();

        $post->save(); 

        if ($dto->postMetas) {
            foreach ($dto->postMetas as $meta) {
                $post->postMetas()->create([
                    'key' => $meta->key,
                    'value' => $meta->value,
                ]);
            }
        }

        if (!empty($dto->categoryIds)) {
            $post->categories()->sync($dto->categoryIds);
        }

        return $post;
    }
}
