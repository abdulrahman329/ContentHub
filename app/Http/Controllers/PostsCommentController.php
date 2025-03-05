<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsCommentController extends Controller
{
    
    // Store a new comment on a specific post (news article)
    public function store(Request $request, Post $post)
    {
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
        // Check if the logged-in user is the owner of the comment or an admin (to check permissions)
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            // If the user isn't authorized (neither the owner nor an admin), redirect back to the post page with an error message
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You are not authorized to edit this comment.');
        }

        // Return the edit view allowing the user to edit the specific comment
        return view('Posts.PostsCommentsEdit', compact('comment'));
    }



    // Update the content of a comment
    public function update(Request $request, Comment $comment)
    {
        // Validate the new content for the comment (ensure it's provided and within the character limit)
        $request->validate([
            'content' => 'required|string|max:1000', // Content must be a string with a max length of 1000 characters
        ]);

        // Check if the logged-in user is the owner of the comment or an admin (authorization check)
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            // If not authorized to edit the comment, redirect the user back with an error message
            return redirect()->route('posts.show', $comment->post_id)->with('error', 'You are not authorized to edit this comment.');
        }

        // Update the comment's content with the new value from the request
        $comment->content = $request->content;

        // Save the updated content to the database
        $comment->save();

        // Redirect back to the post page with a success message after the update
        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment updated successfully.');
    }



    // Delete a specific comment from the post
    public function destroy(Post $post, Comment $comment)
    {
        // Check if the logged-in user is the owner of the comment or an admin (authorization check)
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            // If the user is not authorized to delete the comment, redirect back with an error message
            return redirect()->route('posts.show', $post->id)->with('error', 'You are not authorized to delete this comment.');
        }

        // Delete the comment from the database
        $comment->delete();

        // After deletion, redirect back to the post page with a success message
        return redirect()->route('posts.show', $post->id)->with('success', 'Comment deleted successfully.');
    }
}
