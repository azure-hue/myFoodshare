<template>

    <Header  :user="user"/>

    <div class="grid w-[80%] m-auto gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 ">
        <!-- Example Card -->

        <template v-for="(recipe,index) in recipes.data" :key="recipe.id">
          <RecipeCard
            :description="recipe.recipeDetail.description"
            :imageUrl="recipe.recipeDetail.image.image_url"
            :name="recipe.recipeDetail.name"
            :userId="user.id"
            :recipeId="recipe.id"
            :chefId="recipe.user_id"
          />
        </template>

    </div>

    <div v-if="recipes.data.length === 0" class="flex flex-col items-center justify-center mt-16 text-center text-gray-700">
      <h1 class="text-4xl font-bold text-red-600 mb-2">Oops......</h1>
      <h3 class="text-xl mb-6">Couldn't find anything!!!</h3>
      <img
        :src="BurntFood"
        alt="Raiden can cook!"
        class="w-48 h-48 rounded-full object-cover shadow-lg transform hover:scale-105 transition duration-300"
      />
    </div>


    <!-- Pagination -->
    <div class="mt-4 flex space-x-2">
      <button
        v-if="recipes.prev_page_url"
        @click="goToPage(recipes.current_page - 1)"
        class="btn bg-black text-white"
      >
        Prev
      </button>
      <button
        v-if="recipes.next_page_url"
        @click="goToPage(recipes.current_page + 1)"
        class="btn bg-black text-white"
      >
        Next
      </button>
    </div>

    <Footer />
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import RecipeCard from '@/Pages/Components/RecipeCard.vue'
import { usePage } from '@inertiajs/vue3'
import Header from '@/Pages/Components/Header.vue'
import Footer from '@/Pages/Components/Footer.vue'
import BurntFood from '@/Pages/images/raiden cooking.png'


let user = usePage().props.auth.user
if(user === null) {
  user = ''
}



const props = defineProps({ recipes: Object, query: String })
const recipes = props.recipes



const goToPage = (page) => {
  router.get('/recipes/search', { query: props.query, page }, {
    preserveState: true,
    preserveScroll: true
  })
}


</script>