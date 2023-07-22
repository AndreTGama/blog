<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoriesRequest;
use App\Models\Categories;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        try {
            return ReturnMessage::message(
                false,
                'All Category',
                'All Category',
                null,
                Categories::get(),
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                true,
                'Erro in found categories',
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * get
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function get(int $id) : JsonResponse
    {
        try {
            return ReturnMessage::message(
                false,
                'Category founded',
                'Category founded',
                null,
                Categories::findOrFail($id),
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                true,
                'Erro in found categories',
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * store
     *
     * @param  StoreCategoriesRequest $req
     * @return JsonResponse
     */
    public function store(StoreCategoriesRequest $req): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $req->all();

            $category = Categories::create($data);
            DB::commit();
            return ReturnMessage::message(
                false,
                'Category created with success',
                'Category created with success',
                null,
                $category,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * update
     *
     * @param  StoreCategoriesRequest $req
     * @param  int $id
     * @return JsonResponse
     */
    public function update(StoreCategoriesRequest $req, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $req->all();

            $category = Categories::findOrFail($id);

            $category->update($data);

            DB::commit();
            return ReturnMessage::message(
                false,
                'Category edit with sucsess',
                'Category edit with sucsess',
                null,
                $category,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * delete category by id
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $category = Categories::findOrFail($id);

            $category->delete();

            DB::commit();
            return ReturnMessage::message(
                false,
                "Category remove with sucsess",
                "Category remove with sucsess",
                null,
                [],
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * restore
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $category = Categories::withTrashed()->findOrFail($id)->restore();

            DB::commit();
            return ReturnMessage::message(
                false,
                "Category restored with sucsess",
                "Category restored with sucsess",
                null,
                $category,
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
}
