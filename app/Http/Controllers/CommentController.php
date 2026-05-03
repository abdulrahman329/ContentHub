<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Post;

class CommentController extends Controller

{
    use AuthorizesRequests;

    // STORE a new comment
    public function store(Request $request)
    {
        $this->authorize('create', Comment::class);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
        ]);

        $type = $validated['commentable_type'];

        $post = Post::where('id', $validated['commentable_id'])
            ->where('type', $type)
            ->firstOrFail();

        $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Comment added!');
    }

    // EDIT form
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    // UPDATE the comment
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);

        // commentable_type is the alias (post/news), we need to get the actual model class
        $parent = $comment->commentable;

        // Redirect back to the parent post/news page after updating the comment
        return redirect()->route('posts.show', $parent->id)->with('success', 'Comment updated!');
    }

    // DELETE the comment
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}