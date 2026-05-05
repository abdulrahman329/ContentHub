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

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
        ;
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
