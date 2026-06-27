<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:post,comment'],
            'id' => ['required', 'integer'],
        ]);

        $type = $request->type;
        $id = $request->id;

        $model = $type === 'post'
            ? Post::findOrFail($id)
            : Comment::findOrFail($id);

        $liked = $model->likes()
            ->where('user_id', auth()->id())
            ->exists();

        if ($liked) {
            $model->likes()
                ->where('user_id', auth()->id())
                ->delete();

            $liked = false;
        } else {
            $model->likes()->create([
                'user_id' => auth()->id()
            ]);

            $liked = true;
        }

        $authorLiked = false;

        if ($type === 'post') {

            $authorLiked = $model->likes()
                ->where('user_id', $model->user_id)
                ->exists();

        } else {

            $postAuthorId = $model->commentable->user_id;

            $authorLiked = $model->likes()
                ->where('user_id', $postAuthorId)
                ->exists();
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $model->likes()->count(),
            'author_liked' => $authorLiked,
        ]);
    }
}