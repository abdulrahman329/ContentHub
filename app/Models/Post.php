<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_POST = 'post';
    const TYPE_NEWS = 'news';

    public static function types()
    {
        return [
            self::TYPE_POST,
            self::TYPE_NEWS,
        ];
    }

    // Define fillable fields
    protected $fillable = [
    'title',
    'content',
    'category_id',
    'user_id',
    'image',
    'type',
];

    protected $withCount = ['likes'];

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }


    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return filter_var($this->image, FILTER_VALIDATE_URL)
            ? $this->image
            : asset('storage/' . $this->image);
    }


    // Scope to include comment count
    public function scopeWithCommentCount($query)
    {
        // Count only non-deleted comments
        return $query->withCount([
            'comments as comments_count' => function ($q) {
                $q->whereNull('deleted_at');
            }
        ]);
    }

    // Scope to filter posts by type
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope to filter posts by category
    public function scopeCategory($query, $category_id)
    {
        return $query->where('category_id', $category_id);
    }


    // Method to count trashed posts
    public static function trashedCount()
    {
        return self::onlyTrashed()->count();
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
