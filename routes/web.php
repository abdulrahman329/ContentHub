<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JsonController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Models\User;

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

Route::middleware(['auth', 'role:super_admin|admin'])->group(function () {
    
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

    // ------- Users trash -------
    Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    
});

// ==========================
// Writer and Admin Routes
// ==========================

Route::middleware(['auth', 'role:super_admin|admin|writer'])->group(function () {

    // ------- Post Management -------
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // ------- Posts trash -------
    Route::get('/posts/trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');

});

// ==========================
// Writer-Only Routes
// ==========================

Route::middleware(['auth', 'role:super_admin|admin|writer|user'])->group(function () {

    // ------- Comment Management -------
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');    
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // ------- Comments trash -------
    Route::get('/comments/trash', [CommentController::class, 'trash'])->name('comments.trash');
    Route::post('/comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore');
    Route::delete('/comments/{id}/force-delete', [CommentController::class, 'forceDelete'])->name('comments.forceDelete');
    
    // ------- Public Viewable Posts -------
    Route::resource('posts', PostController::class)->only(['index', 'show']);

});