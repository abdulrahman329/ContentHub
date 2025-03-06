<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Method to display a list of posts, optionally filtered by category
    public function index(Request $request)
    {
        // Retrieve all categories from the Category model
        $categories = Category::all();

        // Initialize the query to retrieve posts, including a count of comments for each post
        $query = Post::withCount('comments')->latest(); // Orders the posts by the latest (created/updated)

        // Check if a category filter is applied via the request (category_id)
        if ($request->has('category_id') && $request->category_id != '') {
            // Filter the posts by the selected category_id
            $query->where('category_id', $request->category_id);
        }
        //paginate
        $posts = $query->paginate(8);

        // Return the view with the posts and categories, passing both as data to the view
        return view('posts.postsindex', compact('posts', 'categories'));
    }

    // Method to show the form for creating a new post
    public function create()
    {
        // Retrieve all categories to allow the user to select a category for the post
        $categories = Category::all();
        
        // Return the view to create a post, passing the categories to the view
        return view('posts.postscreate', compact('categories'));
    }

    // Method to handle the creation of a new post and save it to the database
    public function store(Request $request)
    {
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
        // Retrieve the comments associated with the post, ordered by latest
        $comments = $post->comments()->latest()->get();

        // Return the view to show the specific post and its comments
        return view('posts.postsshow', compact('post', 'comments'));
    }
    
    // Method to show the form for editing a post
    public function edit($id)
    {
        // Retrieve the post with the specified ID
        $post = Post::findOrFail($id);

        // Retrieve all categories for the category selection dropdown
        $categories = Category::all();

        // Return the edit view with the post and categories to allow the user to modify the post
        return view('posts.postsedit', compact('post', 'categories'));
    }

    // Method to update the post in the database after editing
    public function update(Request $request, Post $post)
    {
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

        // Update the post with the validated data
        $post->update($validatedData);

        // Redirect to the posts index page after updating the post
        return redirect()->route('posts.index');
    }

    // Method to delete a specific post
    public function destroy(Post $post)
    {
        // Delete the specified post from the database
        $post->delete();

        // Redirect to the posts index page after deleting the post
        return redirect()->route('posts.index');
    }

    
}
