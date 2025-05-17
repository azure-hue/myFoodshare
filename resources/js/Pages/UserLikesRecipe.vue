<template>


    <Header v-if="user && user.id"  :user="user" />

    <div class="grid w-[80%] m-auto gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 ">
        <template v-if="user && user.id" :user_id="user.id"  v-for="(recipe,index) in recipes" :key="recipe.id">
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

    <Footer />

</template>

<script setup>
import RecipeCard from '@/Pages/Components/RecipeCard.vue'
import Header from '@/Pages/Components/Header.vue'
import Footer from '@/Pages/Components/Footer.vue'
import fetchChefProfile from '@/Pages/Utils/FetchChef'
import { ref } from 'vue'


const user = ref(null)

const { recipes,likes } = defineProps({
    recipes: Object,
    likes: Object,
})

const fetchChef = async () => {
  return fetchChefProfile(likes[0].user_id);
};
fetchChef().then((data) => {
  user.value = data.data;

})








</script>

