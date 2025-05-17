<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\LikeController;


use App\Http\Controllers\ImageController;



Route::get('/', [RecipeController::class, 'index'])->name('welcome');



Route::get('/create-recipe', function () {
    $userId = auth()?->id(); 
    return Inertia::render('UploadRecipes',[
        'userId' => $userId,
    ]);
})->middleware('auth')->name('create-recipe');


Route::post('/like/toggle', [LikeController::class, 'toggleLike'])->name('like.toggle');
Route::get('/like/liked-recipe', [LikeController::class, 'hasUserLikedRecipe'])->name('like.liked-recipe');
Route::get('/likes/count', [LikeController::class, 'countUserLikes'])->name('like.count');



Route::middleware(['auth'])->get('/likes', [LikeController::class, 'getUserLikes']);
























Route::get('/recipes/search', [RecipeController::class, 'search'])->name('recipes.search');




// recipes
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');



Route::get('/recipes/{recipe}', [RecipeController::class, 'edit'])->name('recipes.edit');



// fetch all the recipes user created 
Route::get('user/{userId}/recipes', [RecipeController::class, 'getUserRecipes']);






Route::resource('/recipes', RecipeController::class);


Route::post('/user/user-profile', [ProfileController::class, 'getUserProfile'])
->name('user.user-profile');





Route::post('/api/upload', [ImageController::class, 'upload']);
Route::post('/api/delete', [ImageController::class, 'delete']);

































Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
