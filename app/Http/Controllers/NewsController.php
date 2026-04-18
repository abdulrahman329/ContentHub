<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Comment; 
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    // Display the list of news articles with the count of their comments
    public function index(Request $request)
{
    $categories = Category::all();

    // If category filter is applied, filter posts by category
    $query = News::withCount('comments')->latest();
    
    // Check if a 'category_id' filter is provided in the request
    if ($request->has('category_id') && $request->category_id != ''){
        
        // Filter the news articles by the provided category_id 
        $query->where('category_id', $request->category_id);
    }

    $news = $query->paginate(8);
    

    // Return the view 'news.Newsindex' with the retrieved news and categories
    return view('news.index', compact('news', 'categories'));
}


    // Show the form to create a new news article
    public function create()
    {
        // Retrieve all categories to display them as options in the news creation form
        $categories = Category::all();
        
        // Return the 'Newscreate' view with the categories data, enabling category selection during creation
        return view('news.create', compact('categories'));
    }

    // Store a newly created news article in the database
    public function store(Request $request)
    {
        // Validate incoming request data for creating a news article
        $validatedData = $request->validate([
            'title' => 'required',         // Title is required for every news article
            'content' => 'required',       // Content of the article is mandatory
            'category_id' => 'required',   // Category selection is required
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image, if provided, must meet specific constraints
        ]);

        // Check if the request contains an uploaded image, and if so, store it
        if ($request->hasFile('image')) {
            // Store the uploaded image in the 'images' folder of the public disk and save its path
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;  // Attach the image path to the validated data
        }

        // Assign the authenticated user's ID to the news article to associate it with the logged-in user
        $validatedData['user_id'] = Auth::id();

        // Create a new news article record in the database with the validated data
        News::create($validatedData);

        // Redirect the user back to the news index page after saving the new article
        return redirect()->route('news.index');
    }

    // Display a specific news article and its associated comments
    public function show(News $news)
    {
        $comments = $news->comments() // Retrieve the comments associated with the news article
            ->with('user') // Eager load the user relationship to get the user who posted each comment
            ->latest() // Order the comments by the latest first
            ->paginate(6); // Retrieve the comments for the news article, including the user who posted each comment, ordered by latest and paginated


            $user = $news->user; // This retrieves the user who posted the news article
        // Return the 'Newsshow' view, passing the news article and comments data
        return view('news.show', compact('news', 'comments', 'user'));
    }

    // Show the form to edit an existing news article
    public function edit(News $news)
    {
        // Retrieve the news article by its ID, or fail if it's not found
        // $news = News::findOrFail($id); $id

        // Retrieve all categories to provide them as options in the editing form
        $categories = Category::all();

        // Return the 'Newsedit' view with the existing news data and categories to facilitate editing
        return view('news.edit', compact('news', 'categories'));
    }

    // Update a news article with new data
    public function update(Request $request, News $news)
    {
        // Validate the incoming request data to ensure it's in the proper format
        $validatedData = $request->validate([
            'title' => 'required',         // Title is mandatory
            'content' => 'required',       // Content is required for updating
            'category_id' => 'required',   // The category must be selected
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image, if uploaded, must follow these rules
        ]);

        // If a new image is uploaded, store it and add the path to the validated data
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;  // Save the image path to the validated data
        }

        // Update the news article record in the database with the validated data
        $news->update($validatedData);

        // After updating, redirect back to the news index page
        return redirect()->route('news.index');
    }

    // Delete a news article
    public function destroy(News $news)
    {
        // Delete the specific news article from the database
        $news->delete();

        // Redirect the user back to the news index page after deletion
        return redirect()->route('news.index');
    }
}