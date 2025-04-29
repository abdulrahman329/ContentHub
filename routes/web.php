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
use Spatie\Permission\Models\Role;

// Public Routes

// Home page route (guest accessible)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (authenticated and verified users only)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Profile Routes

Route::middleware('auth')->group(function () {
    // Edit user profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Update user profile
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Update user profile
    Route::patch('/profile/image', [ProfileController::class, 'updateimage'])->name('profile.update-image');
    
    // Delete user account
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Laravel Breeze or Fortify Auth routes
require __DIR__.'/auth.php';

// ==========================
// Admin-only Routes
// ==========================

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // ------- Category Management -------
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // ------- User Management -------
    Route::get('/User/create', [UsersController::class, 'create'])->name('User.create');
    Route::post('/Users', [UsersController::class, 'store'])->name('User.store');
    Route::get('/Users/{User}/edit', [UsersController::class, 'edit'])->name('User.edit');
    Route::put('/Users/{User}', [UsersController::class, 'update'])->name('User.update');
    Route::delete('/Users/{User}', [UsersController::class, 'destroy'])->name('User.destroy');
});

// ==========================
// Writer and Admin Routes
// ==========================

Route::middleware(['auth', 'role:admin|writer'])->group(function () {

    // ------- News Management -------
    Route::get('/News/create', [NewsController::class, 'create'])->name('News.create');
    Route::post('/News', [NewsController::class, 'store'])->name('News.store');
    Route::get('/News/{news}/edit', [NewsController::class, 'edit'])->name('News.edit');
    Route::put('/News/{news}', [NewsController::class, 'update'])->name('News.update');
    Route::delete('/News/{news}', [NewsController::class, 'destroy'])->name('News.destroy');

    // ------- Post Management -------
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// ==========================
// Writer-Only Routes
// ==========================

Route::middleware(['auth', 'role:writer'])->group(function () {

    // ------- News Comments -------
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('news.storeComment');
    Route::delete('news/{news}/comment/{comment}', [CommentController::class, 'destroy'])->name('news.destroyComment');
    Route::get('/news_comments/{comment}/edit', [CommentController::class, 'edit'])->name('news_comments.edit');
    Route::put('/news_comments/{comment}', [CommentController::class, 'update'])->name('news_comments.update');

    // ------- Post Comments -------
    Route::post('/posts/{post}/comments', [PostsCommentController::class, 'store'])->name('posts.storeComment');
    Route::delete('posts/{post}/comment/{comment}', [PostsCommentController::class, 'destroy'])->name('posts.destroyComment');
    Route::get('/posts_comments/{comment}/edit', [PostsCommentController::class, 'edit'])->name('posts_comments.edit');
    Route::put('/posts_comments/{comment}', [PostsCommentController::class, 'update'])->name('posts_comments.update');
});

// ==========================
// General Authenticated User Routes
// ==========================

Route::middleware(['auth'])->group(function () {

    // ------- Public Viewable News -------
    Route::resource('News', NewsController::class)->only(['index', 'show']);

    // ------- Public Viewable Posts -------
    Route::resource('posts', PostController::class)->only(['index', 'show']);

    // ------- News Comments -------
    Route::post('/news/{news}/comments', [CommentController::class, 'store'])->name('news.storeComment');
    Route::delete('news/{news}/comment/{comment}', [CommentController::class, 'destroy'])->name('news.destroyComment');
    Route::get('/news_comments/{comment}/edit', [CommentController::class, 'edit'])->name('news_comments.edit');
    Route::put('/news_comments/{comment}', [CommentController::class, 'update'])->name('news_comments.update');

    // ------- Post Comments -------
    Route::post('/posts/{post}/comments', [PostsCommentController::class, 'store'])->name('posts.storeComment');
    Route::delete('posts/{post}/comment/{comment}', [PostsCommentController::class, 'destroy'])->name('posts.destroyComment');
    Route::get('/posts_comments/{comment}/edit', [PostsCommentController::class, 'edit'])->name('posts_comments.edit');
    Route::put('/posts_comments/{comment}', [PostsCommentController::class, 'update'])->name('posts_comments.update');
});
