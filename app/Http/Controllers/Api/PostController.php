<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Paginated list of posts.
     */
    public function index()
    {
        return new PostsResource(Post::paginate(config('newsapp.posts_per_page')));
    }

    /**
     * Create a post (authenticated).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->category_id = $validated['category_id'];
        $post->user_id = $request->user()->id;
        $post->votes_up = 0;
        $post->votes_down = 0;
        $post->date_written = now();

        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $filename = time().$featuredImage->getClientOriginalName();
            Storage::disk('images')->putFileAs($filename, $featuredImage, $filename);
            $post->featured_image = url('/').'/images/'.$filename;
        }

        $post->save();

        return (new PostResource($post))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Show a single post with its author and comments.
     */
    public function show($id)
    {
        return new PostResource(
            Post::with(['comments', 'author'])->findOrFail($id)
        );
    }

    /**
     * Update a post owned by the authenticated user.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        abort_unless(
            $request->user()->id === $post->user_id,
            Response::HTTP_FORBIDDEN,
            'You can only update your own posts.'
        );

        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
        ]);

        unset($validated['featured_image']);
        $post->fill($validated);

        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $filename = time().$featuredImage->getClientOriginalName();
            Storage::disk('images')->putFileAs($filename, $featuredImage, $filename);
            $post->featured_image = url('/').'/images/'.$filename;
        }

        $post->save();

        return new PostResource($post);
    }

    /**
     * Delete a post owned by the authenticated user.
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        abort_unless(
            $request->user()->id === $post->user_id,
            Response::HTTP_FORBIDDEN,
            'You can only delete your own posts.'
        );

        $post->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Comments belonging to a post.
     */
    public function comments($id)
    {
        $post = Post::findOrFail($id);

        return new CommentsResource(
            $post->comments()->paginate(config('newsapp.comments_per_page'))
        );
    }
}
