<?php

namespace App\Services\Category;

use App\DataTransferObjects\Category\Request\StoreCategoryDTO;
use App\DataTransferObjects\Category\Request\UpdateCategoryDTO;
use App\DataTransferObjects\Common\IndexDTO;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{

    /**
     * Retrieve a paginated list of categories with optional filtering and sorting.
     *
     * @param IndexDTO $dto The data transfer object containing filters, pagination, and sorting options.
     *                      - filters['search']: Optional search term to filter categories by name (partial match).
     *                      - orderBy: The column name to sort by.
     *                      - orderDirection: The direction to sort ('asc' or 'desc').
     *                      - limit: Number of results per page.
     *                      - page: The current page number.
     *
     * @return LengthAwarePaginator A paginated collection of Category models matching the specified criteria.
     */
    public function index(IndexDTO $dto): LengthAwarePaginator
    {
        $query = Category::query();

        if (!empty($dto->filters['search'])) {
            $searchTerm = $dto->filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            });
        }

        $query->orderBy($dto->orderBy, $dto->orderDirection);

        return $query->paginate($dto->limit, ['*'], 'page', $dto->page);
    }

    /**
     * Store a new category.
     *
     * @param StoreCategoryDTO $dto The data transfer object containing category information
     * @return Category The created category instance
     */
    public function store(StoreCategoryDTO $dto) : Category
    {
        return Category::create($dto->toArray());
    }

    /**
     * Update a category with the provided data.
     *
     * @param Category $category The category instance to update
     * @param UpdateCategoryDTO $dto The data transfer object containing the updated category information
     * @return Category The updated category instance
     */
    public function update(Category $category, UpdateCategoryDTO $dto): Category
    {
        $category->update($dto->toArray());
        return $category;
    }

    /**
     * Delete a category from the database.
     *
     * @param Category $category The category instance to be deleted.
     * @return bool Returns true if the category was successfully deleted, false otherwise.
     */
    public function destroy(Category $category): bool
    {
        return $category->delete();
    }

    /**
     * Restore a soft-deleted category.
     *
     * @param Category $category The category instance to restore.
     * @return bool True if the category was successfully restored, false otherwise.
     */
    public function restore(Category $category): bool
    {
        return $category->restore();
    }
}
