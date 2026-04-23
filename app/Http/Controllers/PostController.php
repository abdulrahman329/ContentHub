<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Post::class);
    
        $categories = Category::all();
    
        // Build a query to retrieve posts along with their associated category and the count of comments, ordered by the latest
        $query = Post::with(['category'])
            ->withCount('comments')
            ->latest();
    
        // If the request contains a 'category_id' parameter, filter the posts to only include those that belong to the specified category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        // Paginate the results to show 8 posts per page, including the category and comment count for each post
        $posts = $query->paginate(8);
    
        return view('posts.index', compact('posts', 'categories'));
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
    public function store(Request $request)
    {
        $this->authorize('create', Post::class); // Authorize that the user can create a post

        // Validate the incoming request to ensure necessary data is provided
        $validatedData = $request->validate([
            'title' => 'required',  // Ensure a title is provided
            'content' => 'required',  // Ensure content is provided
            'category_id' => 'required',  // Ensure a category is selected
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Optional image upload with validation
        ]);

        // Check if an image file was uploaded with the request
        if ($request->hasFile('image')) {
            // Store the uploaded image and save its path
            $imagePath = $request->file('image')->store('images', 'public');
            // Add the image path to the validated data
            $validatedData['image'] = $imagePath;
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
        $this->authorize('view', $post); // Authorize that the user can view this specific post

        $comments = $post->comments() // Retrieve the comments associated with the post article
            ->with('user') // Eager load the user relationship to get the user who posted each comment
            ->latest() // Order the comments by the latest first
            ->paginate(6); // Retrieve the comments for the post article, including the user who posted each comment, ordered by latest and paginated

        $user = $post->user; // This retrieves the user who posted the post article

        // Return the view to show the specific post and its comments
        return view('posts.show', compact('post', 'comments', 'user'));
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
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post); // Authorize that the user can update this specific post

        // Validate the incoming request to ensure necessary data is provided
        $validatedData = $request->validate([
            'title' => 'required',  // Ensure a title is provided
            'content' => 'required',  // Ensure content is provided
            'category_id' => 'required',  // Ensure a category is selected
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Optional image upload with validation
        ]);

        // Check if an image file was uploaded with the request
        if ($request->hasFile('image')) {
            // Delete the old image from storage if it exists before storing the new one
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            // Store the new uploaded image and save its path
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }
    
        // Update the post with the validated data
        $post->update($validatedData);

        // Redirect to the posts index page after updating the post
        return redirect()->route('posts.index');
    }

    // Method to delete a specific post
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // Authorize that the user can delete this specific post

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete the specified post from the database
        $post->delete();

        // Redirect to the posts index page after deleting the post
        return redirect()->route('posts.index');
    }

    
}
