<?php

namespace App\Http\Controllers\Post;

use App\DataTransferObjects\Post\Request\StorePostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexPostRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Resources\Common\PaginatedResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Responses\ApiResponse;
use App\Services\Post\PostService;

class PostController extends Controller
{

    /**
     * PostController constructor.
     *
     * @param PostService $postService The service responsible for handling post-related business logic.
     */
    public function __construct(private PostService $postService) {}


    /**
     * Retrieve a paginated list of posts.
     *
     * @param IndexPostRequest $request The request object containing filters and pagination parameters.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the paginated list of posts.
     */
    public function index(IndexPostRequest $request)
    {
        $data = $this->postService->index(dto: $request->toDTO());
        return ApiResponse::success(
            message: 'Posts retrieved successfully.',
            data: new PaginatedResource($data, PostResource::class),
            status: 200
        );
    }

    /**
     * Store a newly created post in the database.
     *
     * @param StorePostRequest $request The request object containing the details of the post to be created.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the operation and containing the created post data.
     */
    public function store(StorePostRequest $request)
    {
        $this->authorize('create', Post::class);
        $data = $this->postService->store(dto: StorePostDTO::fromArray($request->validated()));
        return ApiResponse::success(
            message: 'Post created successfully.',
            data: new PostResource($data),
            status: 201
        );
    }
}
