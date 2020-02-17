<?php

namespace Tessify\Core\Http\Controllers\Api;

use Comments;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Api\Comments\CreateCommentRequest;
use Tessify\Core\Http\Requests\Api\Comments\UpdateCommentRequest;
use Tessify\Core\Http\Requests\Api\Comments\DeleteCommentRequest;

class CommentController extends Controller
{
    public function postCreateComment(CreateCommentRequest $request)
    {
        $comment = Comments::createFromApiRequest($request);

        return response()->json([
            "status" => "success",
            "comment" => $comment,
        ]);
    }

    public function postUpdateComment(UpdateCommentRequest $request)
    {
        $comment = Comments::updateFromApiRequest($request);

        return response()->json([
            "status" => "success",
            "comment" => $comment,
        ]);
    }

    public function postDeleteComment(DeleteCommentRequest $request)
    {
        $comment = Comments::find($request->comment_id);

        // TODO: add validation to protect against injection attacks

        $comment->delete();

        return response()->json([
            "status" => "success"
        ]);
    }
}