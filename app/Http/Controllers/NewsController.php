<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Comment; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    use AuthorizesRequests;

    // Display the list of news articles with the count of their comments
    public function index(Request $request)
{
    $this->authorize('viewAny', News::class); // Authorize that the user can view any news articles

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
        $this->authorize('create', News::class); // Authorize that the user can create a news article

        // Retrieve all categories to display them as options in the news creation form
        $categories = Category::all();
        
        // Return the 'Newscreate' view with the categories data, enabling category selection during creation
        return view('news.create', compact('categories'));
    }

    // Store a newly created news article in the database
    public function store(Request $request)
    {
        $this->authorize('create', News::class); // Authorize that the user can create a news article

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
        $this->authorize('view', $news); // Authorize that the user can view this specific news article

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
        $this->authorize('update', $news); // Authorize that the user can update this specific news article

        // Retrieve all categories to provide them as options in the editing form
        $categories = Category::all();

        // Return the 'Newsedit' view with the existing news data and categories to facilitate editing
        return view('news.edit', compact('news','categories'));
    }

    // Update a news article with new data
    public function update(Request $request, News $news)
    {
        $this->authorize('update', $news); // Authorize that the user can update this specific news article

        // Validate the incoming request data to ensure it's in the proper format
        $validatedData = $request->validate([
            'title' => 'required',         // Title is mandatory
            'content' => 'required',       // Content is required for updating
            'category_id' => 'required',   // The category must be selected
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image, if uploaded, must follow these rules
        ]);

        // If a new image is uploaded, store it and add the path to the validated data
        if ($request->hasFile('image')) {
            // If the news article already has an image, delete the old image from storage before saving the new one
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            // Store the new uploaded image and save its path
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }
    

        // Update the news article record in the database with the validated data
        $news->update($validatedData);

        // After updating, redirect back to the news index page
        return redirect()->route('news.index');
    }

    // Delete a news article
    public function destroy(News $news)
    {
        $this->authorize('delete', $news); // Authorize that the user can delete this specific news article

        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        // Delete the specific news article from the database
        $news->delete();

        // Redirect the user back to the news index page after deletion
        return redirect()->route('news.index');
    }
}