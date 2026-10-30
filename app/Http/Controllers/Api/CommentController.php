<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Add a comment to a post (authenticated).
     */
    public function store(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->date_written = now();
        $comment->post_id = $post->id;
        $comment->user_id = $request->user()->id;
        $comment->save();

        return (new CommentResource($comment))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
