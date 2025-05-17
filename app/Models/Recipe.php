<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    // Protect against mass-assignment vulnerabilities
    protected $fillable = [
        'recipeDetail',    // Recipe details (including name, description, image_url, etc.)
        'ingredients',      // Ingredients (array of objects or JSON)
        'instructions',     // Instructions (array of strings or JSON)
        'user_id',         // User ID of the uploader
    ];

    // Optionally, you can cast 'ingredients', 'instructions', and 'recipe_detail' as JSON
    protected $casts = [
        'ingredients' => 'array',        // Automatically cast to array when retrieving
        'instructions' => 'array',       // Automatically cast to array when retrieving
        'recipeDetail' => 'array',      // Automatically cast recipe_detail as an array (contains name, description, image)
        'user_id' => 'integer',          // Cast user_id to integer
    ];


    // Relationship with the Like model (a recipe can have many likes)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relationship with the User model (a recipe can have many users who liked it)
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
