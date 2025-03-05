<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Fillable properties to prevent mass assignment vulnerabilities
    protected $fillable = ['name'];

    /**
     * Define the relationship with the News model.
     * A category can have many news items.
     */
    public function news()
    {
        return $this->hasMany(News::class);
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
