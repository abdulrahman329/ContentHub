<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    // Define fillable fields
    protected $fillable = [
        'content',
        'user_id',
        'commentable_id',
        'commentable_type',
        'edited_at',
        'edited_by',
        'parent_id',
    ];
    protected $casts = [
        'edited_at' => 'datetime',
    ];

    protected $withCount = ['likes'];
    
    public function getUserImageUrlAttribute(): string
    {
        return $this->user?->image_url
            ?? asset('storage/' . User::DEFAULT_IMAGE);
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->likes()->delete();
        });
    }

    public function getAuthorLikedAttribute(): bool
    {
        // Get the author ID of the post or commentable entity
        $postAuthorId = $this->commentable?->user_id;

        if (!$postAuthorId) {
            return false;
        }

        return $this->likes
            ->contains('user_id', $postAuthorId);
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }

    // Scope to filter only trashed comments visible to the user
    public function scopeOnlyTrashedVisibleToUser($query)
    {
        return $query->onlyTrashed()
            ->when(
                !auth()->user()->hasRole('admin'),
                fn ($q) => $q->where('user_id', auth()->id())
            );
    }

    public function repliesRecursive()
    {
        return $this->replies()->with('repliesRecursive');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by')->withTrashed();
    }

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }
}

