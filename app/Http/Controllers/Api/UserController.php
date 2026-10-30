<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorCommentsResource;
use App\Http\Resources\AuthorPostsResource;
use App\Http\Resources\TokenResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Paginated list of authors.
     */
    public function index()
    {
        return new UsersResource(User::paginate(config('newsapp.authors_per_page')));
    }

    /**
     * Register a new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Show a single author.
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the authenticated user's own profile.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        abort_unless(
            $request->user()->id === $user->id,
            Response::HTTP_FORBIDDEN,
            'You can only update your own profile.'
        );

        if ($request->has('name')) {
            $request->validate(['name' => ['string', 'max:255']]);
            $user->name = $request->get('name');
        }

        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => ['image', 'max:2048']]);

            $avatar = $request->file('avatar');
            $filename = time().$avatar->getClientOriginalName();
            Storage::disk('images')->putFileAs($filename, $avatar, $filename);
            $user->avatar = url('/').'/images/'.$filename;
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Posts written by an author.
     */
    public function posts($id)
    {
        $user = User::findOrFail($id);

        return new AuthorPostsResource(
            $user->posts()->paginate(config('newsapp.posts_per_page'))
        );
    }

    /**
     * Comments written by an author.
     */
    public function comments($id)
    {
        $user = User::findOrFail($id);

        return new AuthorCommentsResource(
            $user->comments()->paginate(config('newsapp.comments_per_page'))
        );
    }

    /**
     * Exchange email + password for the user's API token.
     */
    public function getToken(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(
                ['message' => 'Invalid credentials.'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return new TokenResource(['token' => $user->api_token]);
    }
}
