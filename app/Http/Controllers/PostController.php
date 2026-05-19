<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;

class PostController extends Controller
{
    use AuthorizesRequests;

    // Method to display a list of posts with their associated category and the count of comments, ordered by the latest
    public function index(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $categories = Category::ordered()->get();        
        $trashedCount = Post::trashedCount();

        $query = Post::with(['category', 'user'])
        ->withCommentCount()
        ->latest();

        if ($request->filled('type')) {
            $query->type($request->type);
        }
        
        if ($request->filled('category_id')) {
            $query->Category($request->category_id);
        }

        $posts = $query->paginate(8);

        return view('posts.index', compact('posts', 'categories', 'trashedCount'));
    }

    // Method to show the form for creating a new post
    public function create()
    {
        $this->authorize('create', Post::class); // Authorize that the user can create a post 

        // Retrieve all categories to allow the user to select a category for the post
        $categories = Category::all();
        
        // Return the view to create a post, passing the categories to the view
        return view('posts.create', compact('categories'));
    }

    // Method to handle the creation of a new post and save it to the database
    public function store(StorePostRequest $request)
    {
        // Validate the incoming request data using the StorePostRequest form request class
        $validatedData = $request->validated();

        // Check if an image file was uploaded with the request and store it, adding the path to the validated data
        if ($request->hasFile('image')) {
            $validatedData['image'] = storeImage($request->file('image'));
        }

        // Add the user_id to the validated data to associate the post with the current user
        $validatedData['user_id'] = Auth::id();

        // Create the post using the validated data
        Post::create($validatedData);

        // Redirect to the posts index page after creating the post
        return redirect()->route('posts.index');
    }

    // Method to show a specific post with its comments
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        

        $trashedCommentsCount = $post->comments()
        ->onlyTrashedVisibleToUser()
        ->count();
        
        $post->load([
            'user' => fn ($q) => $q->withTrashed(),
            'category',
        ]);

        $comments = $post->comments()
        ->with([
            'user' => fn ($q) => $q->withTrashed(),     
            'likes'
        ])
        ->withCount('likes')
        ->latest()
        ->paginate(6);
        

        return view('posts.show', compact('post', 'comments', 'trashedCommentsCount'));
    }
    
    // Method to show the form for editing a post
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // Authorize that the user can update this specific post

        // Retrieve all categories for the category selection dropdown
        $categories = Category::all();

        // Return the edit view with the post and categories to allow the user to modify the post
        return view('posts.edit', compact('post', 'categories'));
    }

    // Method to update the post in the database after editing
    public function update(UpdatePostRequest $request, Post $post)
    {

        $validatedData = $request->validated(); // Get the validated data from the request

        // Check if a new image file was uploaded with the request and handle the image update 
        if ($request->hasFile('image')) {

            // Store the new image and get the path
            $oldImage = $post->getRawOriginal('image');
        
            // Store the new image and update the validated data with the new image path
            $validatedData['image'] = storeImage($request->file('image'));
        
            // Delete the old image from storage if it exists
            deleteImage($oldImage);
        }

        $post->update($validatedData);

        return redirect()->route('posts.index', ['type' => $post->type]);
    }

    // Method to delete a specific post
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Authorize that the user can delete this specific post

        // Delete the specified post from the database
        $post->delete();

        return redirect()->route('posts.index', ['type' => $post->type]);
    }   


    // Method to display the list of soft-deleted posts (trash)
    public function trash()
    {
        $this->authorize('viewTrash', Post::class);

        $posts = Post::with(['user', 'category'])
        ->onlyTrashed()
        ->latest()
        ->paginate(10);
        
        return view('posts.trash', compact('posts'));
    }


    // Method to restore a soft-deleted post
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        
        $this->authorize('restore', $post);


        $post->restore();

        return back()->with('success', 'Post restored!');
    }


    // Method to permanently delete a soft-deleted post
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $post);

        deleteImage($post->getRawOriginal('image'));
        $post->forceDelete();

        return back()->with('success', 'Post deleted permanently!');
    }
}