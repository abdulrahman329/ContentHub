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

        $model = match ($request->type) {
            'post' => Post::class,
            'comment' => Comment::class,
        };

        $likeable = $model::findOrFail($request->id);

        $userId = auth()->id();

        $like = $likeable->likes()
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $likeable->likes()->create([
                'user_id' => $userId,
            ]);
            $liked = true;
        }

        return back(); 
    }
}