<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->json('recipeDetail'); // Store recipeDetail as a JSON object
            $table->json('ingredients')->nullable();  // Ingredients stored as JSON
            $table->json('instructions')->nullable(); // Instructions stored as JSON
            $table->unsignedBigInteger('user_id');
    
            $table->timestamps();

            
            // Add a foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
