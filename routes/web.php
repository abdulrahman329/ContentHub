<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
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
    Route::resource('categories', CategoryController::class)->except(['show']);

    // ------- User Management -------
    Route::resource('users', UserController::class)->except(['show']);

    // ------- Users trash -------
    Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/forceDelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    
});

// ==========================
// Writer and Admin Routes
// ==========================

Route::middleware(['auth', 'role:super_admin|admin|writer'])->group(function () {

    
    // ------- Posts trash -------
    Route::get('/posts/trash', [PostController::class, 'trash'])->name('posts.trash');
    Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('/posts/{id}/forcedelete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');

    // ------- Post Management -------
    Route::resource('posts', PostController::class);

});

// ==========================
// Writer-Only Routes
// ==========================

Route::middleware(['auth', 'role:super_admin|admin|writer|user'])->group(function () {

    // // ------- Comment Management -------
    // Route::resource('comments', CommentController::class)->except(['show', 'index', 'create', 'edit']); same as below but i will kep it for clarity
    Route::resource('comments', CommentController::class)->only(['store','update','destroy']);

    // ------- Comments trash -------
    Route::get('/comments/trash', [CommentController::class, 'trash'])->name('comments.trash');
    Route::post('/comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore');
    Route::delete('/comments/{id}/forcedelete', [CommentController::class, 'forceDelete'])->name('comments.forceDelete');
    
    // ------- Public Like Toggle -------
    Route::post('/likes/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');

    // ------- Public Viewable Posts -------
    Route::resource('posts', PostController::class)->only(['index', 'show']);

});