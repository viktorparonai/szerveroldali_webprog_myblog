<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostStoreOrUpdateRequest;
use App\Http\Resources\CategoryResource;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|string|email",
            "password" => "required|string"
        ]);

        if (Auth::attempt($validated)) {
            $user = User::where('email', $validated['email'])->first();
            $token = $user->createToken('loginToken');
            return response()->json(["token" => $token->plainTextToken], 201);
        } else {
            return response()->json(["message" => "Login failed."], 401);
        }
    }

     public function index()
    {
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreOrUpdateRequest $request)
    {
        $validated = $request->validated();
        $validated['is_public'] = $request->boolean('is_public');
        $validated['author_id'] = $request->user()->id;
        $post = Post::create($validated);
        return new PostResource($post);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $post)
    {
         validator(

            ['post' => $post],

            ['post' => 'required|integer']

        )->validate();

        $post = Post::findOrFail($post);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $post)
    {
        validator(
            ['post' => $post],
            ['post' => 'required|integer']
        )->validate();
        $post = Post::findOrFail($post);
        if (!$request->user()->is_admin && $request->user()->id !== $post->author_id)
            return response()->json(["message" => "You cannot do this."], 403);
        $validated = $request->validate([
            "title" => "string|min:10",
            "content" => "string|max:999",
            "is_public" => "boolean",
            'author_id' => "integer|exists:users,id"
        ]);
        $post->update($validated);
        return new PostResource($post);

    }

public function indexCategories(string $post)
    {
        validator(
            ['post' => $post],
            ['post' => 'required|integer']
        )->validate();
        $post = Post::findOrFail($post);
        return CategoryResource::collection($post->categories);
    }


public function indexWithCategories()
    {
        $posts = Post::with('categories')->get();
        return PostResource::collection($posts);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
