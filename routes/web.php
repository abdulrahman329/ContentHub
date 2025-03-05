<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostsCommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\JsonController;
use Illuminate\Support\Facades\Route;


// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (authenticated users only)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes (for managing user profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';


// Resource routes for managing posts
Route::resource('posts', PostController::class);



// Resource routes for managing news articles
Route::resource('News', NewsController::class); 




// Routes for category management
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// Display the form to edit a category
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

// Update the category
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

// Delete the category
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');





// User management routes
Route::get('/User/create', [UsersController::class, 'create'])->name('User.create');
Route::post('/Users', [UsersController::class, 'store'])->name('User.store');

// Display the form to edit a User
Route::get('/Users/{User}/edit', [UsersController::class, 'edit'])->name('User.edit');

// Update the User
Route::put('/Users/{User}', [UsersController::class, 'update'])->name('User.update');

// Delete the User
Route::delete('/Users/{User}', [UsersController::class, 'destroy'])->name('User.destroy');





// Comment-related routes for news articles
Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('news.storeComment');
Route::delete('news/{news}/comment/{comment}', [CommentController::class, 'destroy'])->name('news.destroyComment');


// Route to edit a comment for news
Route::get('/news_comments/{comment}/edit', [CommentController::class, 'edit'])->name('news_comments.edit');

// Route to update a comment after editing for news
Route::put('/news_comments/{comment}', [CommentController::class, 'update'])->name('news_comments.update');




// Comment-related routes for posts
Route::post('/posts/{post}/comments', [PostsCommentController::class, 'store'])->name('posts.storeComment');
Route::delete('posts/{post}/comment/{comment}', [PostsCommentController::class, 'destroy'])->name('posts.destroyComment');

// Route to edit a comment for posts
Route::get('/posts_comments/{comment}/edit', [PostsCommentController::class, 'edit'])->name('posts_comments.edit');

// Route to update a comment after editing for posts
Route::put('/posts_comments/{comment}', [PostsCommentController::class, 'update'])->name('posts_comments.update');

