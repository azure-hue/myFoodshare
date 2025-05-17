<?php

namespace App\Models;
use App\Models\Like;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image_url',
        'profile_image_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship with the Like model (a user can have many likes)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relationship with the Recipe model (a user can have many liked recipes)
    public function likedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'likes');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

}
