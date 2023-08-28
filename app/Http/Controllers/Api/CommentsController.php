<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentsRequest;
use App\Models\Comments;
use App\Models\Posts;
use Illuminate\Http\JsonResponse;

class CommentsController extends Controller
{
    /**
     * store
     *
     * @param  StoreCommentsRequest $request
     * @param  int $idPost
     * @return JsonResponse
     */
    public function store(StoreCommentsRequest $request, int $idPost): JsonResponse
    {

        $post = Posts::find($idPost);
        if (empty($post)) throw new ApiException('Post not found');

        $data = $request->validated();
        $authId = auth()->user()->id;

        Comments::create([
            'comment' => $data['comment'],
            'author_id' => $authId,
            'post_id' => $idPost
        ]);

        return ReturnMessage::message(
            false,
            "Comment created with sucsess",
            "Comment created with sucsess",
            null,
            null,
            200
        );
    }
    /**
     * getAllAuthComments
     *
     * @param  mixed $page
     * @return JsonResponse
     */
    public function getAllAuthComments(int $page): JsonResponse
    {
        $authId = auth()->user()->id;
        $skip = ($page - 1) * 12;
        $comments = Comments::skip($skip)->take(12)
            ->where([
                'author_id' => $authId
            ])->with('posts')
            ->get();

        return ReturnMessage::message(
            false,
            "All Comments",
            "All Comments",
            null,
            $comments,
            200
        );
    }
    /**
     * getOneAuthComments
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getOneAuthComments(int $id): JsonResponse
    {
        $authId = auth()->user()->id;
        $comment = Comments::where([
            'author_id' => $authId,
            'id' => $id
        ])->with('posts')
            ->get();

        return ReturnMessage::message(
            false,
            "One Comments",
            "One Comments",
            null,
            $comment,
            200
        );
    }
    /**
     * getAllModerator
     *
     * @return JsonResponse
     */
    public function getAllModerator(int $page): JsonResponse
    {
        $skip = ($page - 1) * 12;
        $comments = Comments::withTrashed()->skip($skip)->take(12)
            ->with('posts')
            ->with('author')
            ->with('moderator')
            ->get();

        $allComments = Comments::withTrashed()->get();

        return ReturnMessage::message(
            false,
            'All Comments',
            'All Comments',
            null,
            [
                'page' => $page,
                'total' => $allComments->count(),
                'items' => $comments
            ],
            200
        );
    }
    /**
     * getOneModerator
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getOneModerator(int $id): JsonResponse
    {
        $comment = Comments::where([
            'id' => $id
        ])->withTrashed()
            ->with(['posts', 'author', 'moderator'])
            ->get();

        return ReturnMessage::message(
            false,
            "One Comments",
            "One Comments",
            null,
            $comment,
            200
        );
    }
    /**
     * aprove
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function aprove(int $id): JsonResponse
    {
        $comment = Comments::findOrFail($id);
        if ($comment->aprove) throw new ApiException('Post has already been approved');
        if (!$comment->aprove && $comment->moderator_id)
            throw new ApiException('Post has already been desaproved');

        $comment->update([
            'aprove' => true,
            'moderator_id' => auth()->user()->id
        ]);

        return ReturnMessage::message(
            false,
            'Comment aproved',
            'Comment aproved',
            null,
            $comment,
            200
        );
    }
    /**
     * desaprove
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function desaprove(int $id): JsonResponse
    {
        $comment = Comments::findOrFail($id);
        if ($comment->aprove) throw new ApiException('Comment has already been approved');
        if (!$comment->aprove && $comment->moderator_id)
            throw new ApiException('Comment has already been desaproved');

        $comment->update([
            'aprove' => false,
            'moderator_id' => auth()->user()->id
        ]);

        return ReturnMessage::message(
            false,
            'Comment desaproved',
            'Comment desaproved',
            null,
            $comment,
            200
        );
    }
    /**
     * destroy
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $comment = Comments::withTrashed()->where('id', $id)->first();
        $comment->forceDelete();

        return ReturnMessage::message(
            false,
            'Comment destroyed with success',
            'Comment destroyed with success',
            null,
            $comment,
            200
        );

    }
}
