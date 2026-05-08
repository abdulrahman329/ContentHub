<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    // Fillable properties to prevent mass assignment vulnerabilities
    protected $fillable = ['name'];


    // Scope to order categories by name
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }


    /**
     * Define the relationship with the Post model.
    * A category can have many posts.
    */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
