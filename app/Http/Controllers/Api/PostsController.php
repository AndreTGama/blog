<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
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
            $authId = auth()->user()->id;

            $post = Posts::create([
                'title' => $data['title'],
                'post' => $data['post'],
                'author_id' => $authId
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
     * update
     *
     * @param  UpdatePostsRequest $req
     * @param  int $id
     * @return JsonResponse
     */
    public function update(UpdatePostsRequest $req, int $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $req->all();
            $authId = auth()->user()->id;

            $post = Posts::withTrashed()->where('id', $id)->first();

            $post->update([
                'title' => $data['title'],
                'post' => $data['post'],
                'aprove' => false,
                'moderator_id' => null,
                'author_id' => $authId
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
     * desactive post in database
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Posts::findOrFail($id);
            $post->delete();

            DB::commit();

            return ReturnMessage::message(
                false,
                'Post deleted with success',
                'Post deleted with success',
                null,
                $post,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
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
     * restore post was deleted
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $category = Posts::withTrashed()->findOrFail($id)->restore();

            DB::commit();

            return ReturnMessage::message(
                false,
                'Post restored with success',
                'Post restored with success',
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
                null,
                400
            );
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
     * getAllAuthPost
     *
     * @param  int $page
     * @return JsonResponse
     */
    public function getAllAuthPost(int $page): JsonResponse
    {
        try {
            $authId = auth()->user()->id;

            $skip = ($page -1) * 12;
            $posts = Posts::skip($skip)->take(12)->where(['author_id' => $authId])->get();

            return ReturnMessage::message(
                false,
                'All posts make by author logged',
                'All posts make by author logged',
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
     * getOneAuthPost
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getOneAuthPost(int $id): JsonResponse
    {
        try {
            $authId = auth()->user()->id;

            $post = Posts::where([
                'id' => $id,
                'author_id' => $authId
            ])->first();

            if(empty($post)) throw new \Exception('Post Not Found');

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

            if(empty($post)) throw new \Exception('Post Not Found');

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
    /**
     * aprove
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function aprove(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Posts::findOrFail($id);
            if($post->aprove) throw new \Exception('Post has already been approved');
            if(!$post->aprove && $post->moderator_id)
                throw new \Exception('Post has already been desaproved');

            $post->update([
                'aprove' => true,
                'moderator_id' => auth()->user()->id
            ]);
            DB::commit();

            return ReturnMessage::message(
                false,
                'Post aproved',
                'Post aproved',
                null,
                $post,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
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
     * desaprove
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function desaprove(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Posts::findOrFail($id);
            if($post->aprove) throw new \Exception('Post has already been approved');
            if(!$post->aprove && $post->moderator_id)
                throw new \Exception('Post has already been desaproved');

            $post->update([
                'aprove' => false,
                'moderator_id' => auth()->user()->id
            ]);
            DB::commit();

            return ReturnMessage::message(
                false,
                'Post desaproved with success',
                'Post desaproved with success',
                null,
                $post,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
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
     * destroy post in database
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $post = Posts::withTrashed()->where('id',$id)->first();
            $post->forceDelete();

            DB::commit();

            return ReturnMessage::message(
                false,
                'Post destroyed with success',
                'Post destroyed with success',
                null,
                $post,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
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
