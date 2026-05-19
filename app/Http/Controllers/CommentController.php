<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Post;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;

class CommentController extends Controller

{
    use AuthorizesRequests;

    // STORE a new comment
    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();

        $post = Post::findOrFail($validated['commentable_id']);

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
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update([
            'content' => $request->validated()['content'],
            'edited_by' => auth()->id(),
            'edited_at' => now(),
        ]);

        // Redirect back to the parent post/news page after updating the comment
        return redirect()->route('posts.show', $comment->commentable_id)->with('success', 'Comment updated!');
    }

    // DELETE the comment
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }


    public function trash()
{
    $this->authorize('viewTrash', Comment::class);

    $comments = Comment::onlyTrashedVisibleToUser()
        ->with('user')
        ->latest()
        ->paginate(10);

    return view('comments.trash', compact('comments'));
}
    public function restore($id)
    {
        $comment = Comment::withTrashed()
            ->findOrFail($id);
    
        $this->authorize('restore', $comment);
    
        $comment->restore();
    
        return redirect()->route('posts.show', $comment->commentable_id)->with('success', 'Comment restored!');
    }

    public function forceDelete($id)
    {
        $comment = Comment::withTrashed()
            ->findOrFail($id);

        $this->authorize('forceDelete', $comment);

        $postId = $comment->commentable_id;

        $comment->forceDelete();

        return redirect()->route('posts.show', $postId)->with('success', 'Comment permanently deleted!');
    }
}