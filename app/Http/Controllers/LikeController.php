<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Like;
use Inertia\Inertia;


class LikeController extends Controller
{

    public function countUserLikes(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id'
        ]);

        try {
            // Count likes for the user
            $likeCount = Like::where('user_id', $validated['user_id'])->count();

            return response()->json([
                'success' => true,
                'user_id' => $validated['user_id'],
                'like_count' => $likeCount,
                'message' => "User has {$likeCount} likes"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to count user likes',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function hasUserLikedRecipe(Request $request)
    {
        $userId = $request->query('user_id');
        $recipeId = $request->query('recipe_id');
    
        if (!$userId || !$recipeId) {
            return response()->json(['error' => 'Missing user_id or recipe_id'], 400);
        }
    
        $likeExists = Like::where('user_id', $userId)
                          ->where('recipe_id', $recipeId)
                          ->exists();
    
        return response()->json(['liked' => $likeExists]);
    }

        
    public function toggleLike(Request $request)
    {
        $userId = $request->input('user_id');
        $recipeId = $request->input('recipe_id');

        // Check if the like already exists
        $existingLike = Like::where('user_id', $userId)
                            ->where('recipe_id', $recipeId)
                            ->first();
        // 🔐 Check if either is missing
        if (!$userId || !$recipeId) {
            return back()->with('fail', 'No user id or recipe id given!');
        }

        if ($existingLike) {
            // If exists, remove it (unlike)
            $existingLike->delete();

            return back()->with('success', 'Recipe unliked successfully!');

        } else {
            // If not, create it (like)
            Like::create([
                'user_id' => $userId,
                'recipe_id' => $recipeId,
            ]);

            return back()->with('success', 'Recipe liked successfully!');

        }
    }

    public function getUserLikes(Request $request)
    {

        $userId = auth()?->id();
        // Check if the user is authenticated
        if($userId === null || !auth()->check()) {
            return back()->with('failure', 'user is not  signed in!');
        }

        // Load likes and their associated recipes
        $likes = Like::with('recipe')
            ->where('user_id', $userId)
            ->get();


        $recipes = $likes->pluck('recipe');

        return Inertia::render('UserLikesRecipe', [
            'likes' => $likes,
            'recipes' => $recipes->values(),
        ]);
    }

}
