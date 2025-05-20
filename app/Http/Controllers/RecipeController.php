<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $recipes = Recipe::select('id','user_id','recipeDetail')->paginate(6);
        $user = auth()->user();

        // dd($recipes);

        return Inertia::render('Welcome', [
            'recipes' => $recipes,
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_image_url' => $user->profile_image_url,
            ] : null,
        ]);
    }

    public function create()
    {
        // Return view/form to create a recipe (optional if using Inertia/Vue)
    }

    public function store(Request $request)
    {
        // Save a new recipe
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'recipeDetail' => 'required|array',
            'ingredients' => 'required|array',
            'instructions' => 'required|array',
        ]);

        Recipe::create($validated);

        return back()->with('success', 'Recipe uploaded successfully!');
    }


    public function show(Recipe $recipe, Request $request)
    {
        // Get the user ID from the query parameter
        $userId = $request->query('query')['user'];
        
        // Fetch the User model using the user ID
        $user = User::find($userId);
    
        return Inertia::render('SingleRecipe', [
            'recipe' => $recipe,  // Pass the recipe data
            'user' => $user,      // Pass the user data
        ]);
    }
    


    public function edit(Recipe $recipe)
    {
        return Inertia::render('RecipeEdit',[
            'recipe' => $recipe
        ]);
    }

    public function update(Request $request, Recipe $recipe)
    {

        // return response()->json([
        //     'message' => 'Update route hit successfully!',
        //     'recipe_id' => $recipe->id
        // ]);
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'recipeDetail' => 'required|array',
            'ingredients' => 'required|array',
            'instructions' => 'required|array',
        ]);
    
        $recipe->update($validated);
        return response()->json(['message' => 'Recipe updated successfully']);
    }

    public function destroy(Recipe $recipe)
    {
        // Optionally check if user is authorized
        if (auth()->id() !== $recipe->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $recipe->delete();
        return response()->json(null, 204);
    }
    


    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        $input = strtolower($searchTerm);
        $output = ucfirst($input);
    
        // Paginate the results
        $recipes = Recipe::where('recipedetail->name', 'LIKE', "%{$output}%")
            ->orWhere('recipedetail->description', 'LIKE', "%{$output}%")
            ->orWhere('ingredients', 'LIKE', "%{$output}%")
            ->paginate(10);
    
        return Inertia::render('SearchResults', ['recipes' => $recipes, 'query' => $output]);
    }
    
    // In your controller (e.g., RecipeController.php)
    public function getUserRecipes($userId)
    {
        // Fetch the user
        $user = User::findOrFail($userId);

        // Get all recipes created by this user
        $recipes = $user->recipes()->paginate(3); // This calls the `recipes()` method in the User model

        // Return the recipes (you can pass it to a view or API response)
        return response()->json($recipes);
    }



}
