<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\News; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NewsCommentController extends Controller
{
    use AuthorizesRequests;

// Store a new comment on a specific news article
public function store(Request $request, News $news)
{
    $this->authorize('create', Comment::class); // Authorize that the user can create a comment

    // Validate that the content of the comment is not empty and is within the character limit
    $request->validate([
        'content' => 'required|string|max:1000', // Ensure content is a string with a max of 1000 characters
    ]);

    // Create and store a new comment in the database, linking it to the logged-in user and the news article
    Comment::create([
        'content' => $request->content,      // The actual content of the comment
        'user_id' => Auth::id(),             // Associate the comment with the logged-in user
        'news_id' => $news->id,              // Link the comment to the specific news article
    ]);

    // After storing the comment, redirect back to the news article page with a success message
    return redirect()->route('news.show', $news->id)->with('success', 'Comment added!');
}



// Show the form to edit a specific comment
public function edit(Comment $comment)
{
    $this->authorize('update', $comment); // Authorize that the user can update the comment

    // Return the 'newsCommentsedit' view to allow the user to edit the comment
    return view('news.comments.edit', compact('comment'));
}



// Update the content of a comment
public function update(Request $request, Comment $comment)
{
    $this->authorize('update', $comment); // Authorize that the user can update the comment

    // Validate that the content of the comment is not empty and does not exceed 1000 characters
    $request->validate([
        'content' => 'required|string|max:1000', // Ensure content is a string with a maximum length of 1000 characters
    ]);

    // Update the comment content with the new value from the request
    $comment->content = $request->content;

    // Save the updated comment to the database
    $comment->save();

    // Redirect to the news article's page with a success message
    return redirect()->route('news.show', $comment->news_id)->with('success', 'Comment updated successfully.');
}



// Delete a specific comment
public function destroy(News $news, Comment $comment)
{
    $this->authorize('delete', $comment); // Authorize that the user can delete the comment

    // Delete the comment from the database
    $comment->delete();

    // Redirect to the news article page with a success message
    return redirect()->route('news.show', $news->id)->with('success', 'Comment deleted successfully.');
}
}