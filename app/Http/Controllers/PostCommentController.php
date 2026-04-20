<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostCommentController extends Controller
{
    use AuthorizesRequests;

    // Store a new comment on a specific post (news article)
    public function store(Request $request, Post $post)
    {
        $this->authorize('create', Comment::class); // Authorize that the user has permission to create a comment

        // Validate that the content of the comment is provided and doesn't exceed 1000 characters
        $request->validate([
            'content' => 'required|string|max:1000', // Ensure the content is a string and within 1000 characters
        ]);

        // Create and store a new comment linked to the current logged-in user and the specific post
        Comment::create([
            'content' => $request->content,      // The content of the comment entered by the user
            'user_id' => Auth::id(),             // Associate the comment with the logged-in user’s ID
            'post_id' => $post->id,              // Link the comment to the specific post (news article)
        ]);

        // After successfully adding the comment, redirect the user back to the post page with a success message
        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added!');
    }



    // Show the form to edit a specific comment
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment); // Authorize that the user has permission to update the comment

        // Return the edit view allowing the user to edit the specific comment
        return view('posts.comments.edit', compact('comment'));
    }



    // Update the content of a comment
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment); // Authorize that the user can update the comment

        // Validate the new content for the comment (ensure it's provided and within the character limit)
        $request->validate([
            'content' => 'required|string|max:1000', // Content must be a string with a max length of 1000 characters
        ]);

        // Update the comment's content with the new value from the request
        $comment->content = $request->content;

        // Save the updated content to the database
        $comment->save();

        // Redirect back to the post page with a success message after the update
        return redirect()->route('posts.show', $comment->post->id)->with('success', 'Comment updated successfully.'); //fff
    }



    // Delete a specific comment from the post
    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment); // Authorize that the user can delete the comment

        // Delete the comment from the database
        $comment->delete();

        // After deletion, redirect back to the post page with a success message
        return redirect()->route('posts.show', $post->id)->with('success', 'Comment deleted successfully.');
    }
}
