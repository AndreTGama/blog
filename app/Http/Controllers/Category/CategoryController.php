<?php

namespace App\Http\Controllers\Category;

use App\DataTransferObjects\Category\Request\StoreCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\IndexCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Common\PaginatedResource;
use App\Models\Category;
use App\Responses\ApiResponse;
use App\Services\Category\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    /**
     * Retrieve a paginated list of categories.
     *
     * @param IndexCategoryRequest $request The request object containing filter and pagination parameters
     * @return \Illuminate\Http\JsonResponse A JSON response containing paginated categories
     */
    public function index(IndexCategoryRequest $request)
    {
        $data = $this->categoryService->index(dto: $request->toDTO());

        return ApiResponse::success(
            message: 'Categories retrieved successfully.',
            data: new PaginatedResource($data, CategoryResource::class),
            status: 200
        );
    }

    /**
     * Store a newly created category in the database.
     *
     * @param StoreCategoryRequest $request The validated request containing category data
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to create a category
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Category created successfully.",
     *   "data": { "id": 1, "name": "Technology", "slug": "technology", ... }
     * }
     *
     * @response 500 {
     *   "success": false,
     *   "message": "Failed to create category.",
     *   "data": null
     * }
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->authorize('create', Category::class);
            $data = $this->categoryService->store(StoreCategoryDTO::fromArray($request->validated()));
            return ApiResponse::success(
                message: 'Category created successfully.',
                data: $data,
                status: 201
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to create category.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return ApiResponse::success(
            message: 'Category retrieved successfully.',
            data: new CategoryResource($category),
            status: 200
        );
    }

    /**
     * Update an existing category.
     *
     * @param UpdateCategoryRequest $request The validated request containing category update data
     * @param Category $category The category instance to be updated
     * @return \Illuminate\Http\JsonResponse Success response with updated category data or error response
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the category
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $this->authorize('update', $category);
            $data = $this->categoryService->update($category, $request->toDTO());
            return ApiResponse::success(
                message: 'Category updated successfully.',
                data: $data,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to update category.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }

    /**
     * Delete a category
     *
     * Deletes the specified category from the database. The user must be authorized
     * to delete the category through the delete policy check.
     *
     * @param Category $category The category instance to be deleted
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with success (200) or error (500) status
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to delete the category
     */
    public function destroy(Category $category)
    {
        try {
            $this->authorize('delete', $category);
            $this->categoryService->destroy($category);
            return ApiResponse::success(
                message: 'Category deleted successfully.',
                data: null,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to delete category.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }

    /**
     * Restore a soft-deleted category.
     *
     * @param Category $category The category instance to restore.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to restore the category.
     */
    public function restore(Category $category)
    {
        try {
            $this->authorize('restore', $category);
            $this->categoryService->restore($category);
            return ApiResponse::success(
                message: 'Category restored successfully.',
                data: null,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to restore category.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }
}
