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
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}

