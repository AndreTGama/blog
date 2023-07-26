<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostsRequest;
use App\Models\Posts;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * store
     *
     * @param  StorePostsRequest $req
     * @return JsonResponse
     */
    public function store(StorePostsRequest $req): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $req->all();
            $id = auth()->user()->id;

            $post = Posts::create([
                'title' => $data['title'],
                'post' => $data['post'],
                'author_id' => $id
            ]);

            DB::commit();
            return ReturnMessage::message(
                false,
                'Post created with success',
                'Post created with success',
                null,
                $post,
                200
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::message(true, $e->getMessage(),$e->getMessage(),null, null, 400);
        }

    }
    /**
     * getAll
     *
     * @param  int $page
     * @return JsonResponse
     */
    public function getAll(int $page): JsonResponse
    {
        /*
            It is possible to use laravel's pagination(), but for the features that I will do in the APP,
            I didn't see the need to use it
        */

        try {
            $skip = ($page -1) * 12;
            $posts = Posts::skip($skip)->take(12)->where('aprove', true)->get();

            return ReturnMessage::message(
                false,
                'All posts in system',
                'All posts in system',
                null,
                $posts,
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                null,
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
    public function getOne(int $id): JsonResponse
    {
        try {
            $post = Posts::where([
                'id' => $id,
                'aprove' => true
            ])->first();

            return ReturnMessage::message(
                false,
                'Post founded',
                'Post founded',
                null,
                $post,
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                null,
                400
            );
        }
    }
    /**
     * getAllModerator
     *
     * @param  int $page
     * @return JsonResponse
     */
    public function getAllModerator(int $page): JsonResponse
    {
      try {
            $skip = ($page -1) * 12;
            $posts = Posts::skip($skip)->take(12)->whereNull('moderator_id')->get();

            return ReturnMessage::message(
                false,
                'All posts in system',
                'All posts in system',
                null,
                $posts,
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                null,
                400
            );
        }
    }
    /**
     * getOneModerator
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getOneModerator(int $id): JsonResponse
    {
        try {
            $post = Posts::where([
                'id' => $id
            ])->first();

            return ReturnMessage::message(
                false,
                'Post founded',
                'Post founded',
                null,
                $post,
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                true,
                $e->getMessage(),
                $e->getMessage(),
                null,
                null,
                400
            );
        }
    }
}
