<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

// Route::get("/feladat", function(){
//     return view("feladat");
// });

// Route::get("/feladat2/{id}", function($id){
//     return $id;
// })->whereNumber("id");

// Route::get("/create-post", function(){
//     return "létrehoztál egy postot";
// });

Route::get('/', function () {
   return view('bloglayout');
});

Route::get('/', function () {
    $posts = Post::all();
    return view('posts.index', ['posts' => $posts]);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
