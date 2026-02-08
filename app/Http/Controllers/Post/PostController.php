<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexPostRequest;
use App\Http\Resources\Common\PaginatedResource;
use App\Http\Resources\Post\PostResource;
use App\Responses\ApiResponse;
use App\Services\Post\PostService;

class PostController extends Controller
{

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
}
