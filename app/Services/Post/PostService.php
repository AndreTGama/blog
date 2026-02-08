<?php

namespace App\Services\Post;

use App\DataTransferObjects\Common\IndexDTO;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{

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

        return $query->paginate($dto->limit, ['*'], 'page', $dto->page);
    }
}
