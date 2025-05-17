<template>
    <main class="p-6 bg-base-200 w-full border" style="font-family: Playwrite DK Loopet, cursive; background-color: #f4f2f0;" >
  
    <div class="py-10 px-6 md:px-12 bg-[#fef7f1] text-gray-800">
      <h1 class="text-2xl md:text-4xl font-semibold mb-2" style="font-family: 'Playwrite DK Loopet', cursive;">
        Hello {{ user?.name || 'Guest' }},
      </h1>
      <p class="text-lg md:text-xl">
        What would you like to cook today?
      </p>
    </div>
      <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 ">
        <!-- Example Card -->

        <template v-for="(recipe,index) in recipes.data" :key="recipe.id">
          <RecipeCard
            :description="recipe.recipeDetail.description"
            :imageUrl="recipe.recipeDetail.image.image_url"
            :name="recipe.recipeDetail.name"
            :userId="user_id"
            :recipeId="recipe.id"
            :chefId="recipe.user_id"
          />
        </template>

      </div>
              <!-- Pagination Controls -->
    <div class="mt-6 flex justify-center gap-4 ">
      <button
        v-if="recipes.prev_page_url"
        @click="changePage(recipes.current_page - 1)"
        class="px-4 py-2 bg-gray-700 text-white rounded"
      >
        Previous
      </button>

      <button
        v-if="recipes.next_page_url"
        @click="changePage(recipes.current_page + 1)"
        class="px-4 py-2 bg-gray-700 text-white rounded"
      >
        Next
      </button>
    </div>

    </main>
</template>

<script setup>
import RecipeCard from '@/Pages/Components/RecipeCard.vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/vue3'

const user = usePage().props.auth.user

const {recipes} = defineProps({
  recipes: Object,
  user_id: Number,
})

const changePage = (page) => {
  Inertia.get(route('welcome'), { page }, {
    preserveScroll: true, // This preserves the scroll position
    preserveState: true,  // This ensures the current state (like filters) is maintained
    onSuccess: (res) => {
      console.log('Recipes fetched successfully');
    },
    onError: (error) => {
      console.error('Error fetching recipes:', error);
    }
  });
}





</script>

