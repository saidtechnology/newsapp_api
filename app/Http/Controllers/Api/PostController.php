<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentstResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @return PostsResource
     */

    public function index()
    {
        $posts = Post::paginate(env('POSTS_PER_PAGE'));
        return new PostsResource($posts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
    }


    /**
     * @param $id
     * @return PostResource
     */

    public function show($id)
    {
        return new PostResource(Post::find($id));
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


    /**
     * @param $id
     * @return CommentstResource
     */

    public function comments($id)
    {
        $post = Post::find($id);
        $comments = $post->comments()->paginate(env('COMMENTS_PER_PAGE'));
        return new CommentstResource($comments);
    }
}
