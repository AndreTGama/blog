<?php 

namespace App\DataTransferObjects\Post\Request;

use App\DataTransferObjects\PostMeta\Response\IndexPostMetaDTO;

class StorePostDTO
{
    /**
     * Data Transfer Object for storing a new post.
     *
     * @param string|null $coverImage The URL of the cover image for the post (optional).
     * @param string $title The title of the post.
     * @param string $slug The slug for the post.
     * @param string $excerpt A short excerpt of the post.
     * @param string $content The main content of the post.
     * @param string $status The status of the post (e.g., draft, published).
     * @param IndexPostMetaDTO|null $postMeta The post meta data for the post (optional).
     * @param array $categoryIds An array of category IDs associated with the post.
     */
    public function __construct(
        public ?string           $coverImage,
        public string            $title,
        public string            $excerpt,
        public string            $content,
        public string            $status,
        public ?array            $postMeta,
        public array             $categoryIds
    ) {}

    /**
     * Creates a new instance of the class from an associative array.
     *
     * @param array $data Associative array containing 'title', 'slug', 'excerpt', 'content', and 'category_ids' keys.
     * @return self Returns an instance of the class populated with the provided data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            coverImage: $data['cover_image'] ?? null,
            title: $data['title'],
            excerpt: $data['excerpt'],
            content: $data['content'],
            status: $data['status'],
            postMeta: array_key_exists('post_meta', $data) ? array_map(fn($meta) => IndexPostMetaDTO::fromArray($meta), $data['post_meta']) : null,
            categoryIds: $data['category_ids'] ?? []
        );
    }

    /**
     * Converts the StorePostDTO object properties to an associative array.
     *
     * @return array{
     *     cover_image: string|null,
     *     title: string,
     *     slug: string,
     *     excerpt: string,
     *     content: string,
     *     status: string,
     *     post_meta: array|null,
     *     category_ids: array
     * }
     * Returns an array containing the post's title, slug, excerpt, content, and associated category IDs.
     */
    public function toArray(): array
    {
        return [
            'cover_image' => $this->coverImage,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'status' => $this->status,
            'post_meta' => $this->postMeta ? array_map(fn($meta) => $meta->toArray(), $this->postMeta) : null,
            'category_ids' => $this->categoryIds
        ];
    }
}