<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreOrUpdateRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index()
    {

        // $posts = Post::all();
        $posts = Post::with('author')->paginate(10);
        return view('posts.index', ['posts' => $posts]);

    }

    public function show(Post $post){
        return view('posts.show', ['post' => $post ]);
    }

    public function create(){
        return view('posts.create', [
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }

    public function edit(Post $post){
        return view('posts.edit', [
            'post' => $post,
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }

   public function store(PostStoreOrUpdateRequest $request){
        $validated = $request->validated();
        $validated['is_public'] = $request -> has('is_public');
        $post = Post::create($validated);
        $post -> categories() -> sync($validated['categories'] ?? []);
        Session::flash('post-created', $post -> title);
        return redirect() -> route('posts.index');
    }

    public function update(PostStoreOrUpdateRequest $request, Post $post){
        $validated = $request->validated();
        $validated['is_public'] = $request -> has('is_public');
        $post -> update($validated);
        $post -> categories() -> sync($validated['categories'] ?? []);
        return redirect() -> route('posts.index');
    }


}
