<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
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
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ==========================
// Writer and Admin Routes
// ==========================

Route::middleware(['auth', 'role:admin|writer'])->group(function () {

    // ------- News Management -------
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

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

Route::middleware(['auth', 'role:admin|writer|user'])->group(function () {

    // ------- News Comments -------
    Route::post('/news/{news}/comments', [NewsCommentController::class, 'store'])->name('news.comments.store');
    Route::delete('news/{news}/comment/{comment}', [NewsCommentController::class, 'destroy'])->name('news.comments.destroy');
    Route::get('/news_comments/{comment}/edit', [NewsCommentController::class, 'edit'])->name('news.comments.edit');
    Route::put('/news_comments/{comment}', [NewsCommentController::class, 'update'])->name('news.comments.update');

    // ------- Post Comments -------
    Route::post('/posts/{post}/comments', [PostCommentController::class, 'store'])->name('posts.comments.store');
    Route::delete('posts/{post}/comment/{comment}', [PostCommentController::class, 'destroy'])->name('posts.comments.destroy');
    Route::get('/posts_comments/{comment}/edit', [PostCommentController::class, 'edit'])->name('posts.comments.edit');
    Route::put('/posts_comments/{comment}', [PostCommentController::class, 'update'])->name('posts.comments.update');
});

// ==========================
// General Authenticated User Routes
// ==========================

Route::middleware(['auth', 'role:admin|writer|user'])->group(function () {

    // ------- Public Viewable News -------
    Route::resource('news', NewsController::class)->only(['index', 'show']);

    // ------- Public Viewable Posts -------
    Route::resource('posts', PostController::class)->only(['index', 'show']);


});
