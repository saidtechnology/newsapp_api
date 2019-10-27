<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResouce;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return CommentResouce
     */

    public function store(Request $request,$id)
    {
        $request->validate([
            'content' => 'required',
            'post_id' => 'required',
        ]);
        $comment = new Comment();
        $comment->content = $request->get('content');
        $comment->date_written = Carbon::now()->format('Y-m-d H-i-s');
        $comment->post_id = $id;
        $comment->user_id = $request->user()->id;
        $comment->save();
        return new CommentResouce($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
