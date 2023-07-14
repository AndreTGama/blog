<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoriesRequest;
use App\Models\Categories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
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
                false,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
}
