<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // If you want to add extra fields to the likes table, add them here
    protected $fillable = [
        'user_id', 'recipe_id',  // assuming a Like belongs to a User and a Recipe
    ];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class); // A like belongs to a user
    }

    // Relationship with the Recipe model
    public function recipe()
    {
        return $this->belongsTo(Recipe::class); // A like belongs to a recipe
    }
}
