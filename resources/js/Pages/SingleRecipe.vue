<template>

<div>

<!-- 🧭 Main Navigation Bar -->
<nav class="flex flex-wrap justify-center gap-8 p-4 shadow-md bg-white/80 backdrop-blur-sm sticky top-0 z-50">
  <Link
    :href="route('welcome')"
    class="text-gray-700 hover:text-blue-600 font-semibold transition-colors duration-200"
  >Home</Link>

  <Link
    :href="route('dashboard')"
    class="text-gray-700 hover:text-blue-600 font-semibold transition-colors duration-200"
  >Dashboard</Link>

  <Link
    :href="route('create-recipe')"
    class="text-gray-700 hover:text-blue-600 font-semibold transition-colors duration-200"
  >Create Recipe</Link>
</nav>


    <!-- 🌄 Hero Parallax -->
    <div class="parallax-bg flex flex-col items-center justify-center relative min-h-screen border " id="hero">
    <div class=" hero-content bg-black/40 rounded z-10  relative">
        <img
        :src="user.profile_image_url"
        alt="Chef Profile"
        class="w-[12rem] sm:w-[17rem] rounded-full shadow-2xl"
        />
        <div class="max-w-lg space-y-6 text-white">
        <h1 class="text-5xl underline font-bold">{{ user.name }}</h1>
        <div class="flex space-x-4">
            <img :src="facebook" class="w-6 h-6" />
            <img :src="instagram" class="w-6 h-6" />
        </div>
            <!-- 🔗 Sticky Horizontal Nav -->
        <div class="border fixed bottom-4 left-1/2 transform -translate-x-1/2  bg-base-100/90 bg-base-100/90 backdrop-blur-sm p-2 rounded-lg shadow-md">
        <nav class="flex gap-2 justify-end items-center">
            <a href="#hero" class="btn btn-xs sm:btn-sm btn-outline">Top</a>
            <a href="#ingredients" class="btn btn-xs sm:btn-sm btn-info btn-outline">Ingredients</a>
            <a href="#instructions" class="btn btn-xs sm:btn-sm btn-success btn-outline">Instructions</a>
            <a href="#details" class="btn btn-xs sm:btn-sm btn-warning btn-outline">Details</a>
        </nav>
        </div>
        <button :to="`/profile/${user.id}`" class="btn w-full bg-inherit text-white mt-4">
            View Profile
        </button>
        </div>
    </div>
    <div class="absolute inset-0 bg-black/40 z-0"></div>
    </div>

     <!-- 📋 Details Section (optional parallax) -->
     <div class="parallax-section details-bg overflow-auto" id="details">
    <div class="section-content text-white">
        <h2 class="text-4xl pl-7 font-bold">Recipe Details </h2>
        <!-- 🍽️ Recipe Intro Section -->

                <!-- 🖼️ Recipe Image -->
                <h1 class="text-4xl sm:text-5xl font-bold pb-4  text-center text-white">{{ recipeDetail.name }}</h1>
                <div class="flex items-center justify-center">
                    <img
                        :src="recipeDetail.image.image_url"
                        alt="Recipe Image"
                        class="w-[90%] h-[50vh] lg:w-[50%] shadow-lg  object-fit"
                    />
                </div>
                <section class="bg-inherit  py-10 px-4 sm:px-8 md:px-16 lg:px-32">
                <div class="lg:flex-row items-center gap-10">
                    
                    <!-- 📝 Recipe Text -->
                    <div class=" text-center lg:text-center">
                        <p class="text-lg pb-[2rem]
                        m-auto
                        p-2
                        bg-black/40
                        rounded mb-[3rem]
                        lg:w-[60%]
                        text-white leading-relaxed">
                            {{ recipeDetail.description }}
                        </p>
                    </div>


                </div>
                </section>

    </div>
    </div>

    <!-- 🍅 Ingredients Parallax -->
    <div class="parallax-section overflow-auto  ingredients-bg" id="ingredients">
        <h2 class="text-4xl pl-7 text-white  font-bold">Ingredients </h2>
        <div class="section-content p-[2rem] lg:text-[1.7rem] text-white lg:grid lg:grid-cols-3">
        <ul v-if="groupedIngredients.noGroup" class="list-disc  pl-5">
            <li v-for="(item, index) in groupedIngredients.noGroup" :key="index">
                {{ item.amount }} {{ item.unit }} {{ item.ingredient }}
            </li>
        </ul>
        <div  v-for="(ingredients, groupName) in groupedIngredients.byGroup" :key="groupName" class="mb-6">
            <h1 class="text-xl capitalize font-bold mb-2">{{ groupName }}</h1>
            <ul class="list-disc pl-5 space-y-1">
                <li v-for="(item, index) in ingredients" :key="index">
                {{ item.amount }} {{ item.unit }} {{ item.ingredient }}
                </li>
            </ul>
        </div>


    </div>
    </div>

    <!-- 🍳 Instructions Parallax -->
    <div class="parallax-section overflow-auto instructions-bg" id="instructions">
    <div class="section-content  text-white">
        <h2 class="text-4xl pl-7 font-bold">Instructions </h2>
        <ul class="list-decimal mb-[2rem] pl-5 space-y-2 lg:h-[100vh] lg:text-[1.2rem] bg-black/40 p-7">
            <li class="p-[1.2rem]" v-for="(step, index) in instructions" :key="index">
                {{ step }}
            </li>
        </ul>

    </div>
    </div>

   


</div>
</template>

<style scoped>
html {
scroll-behavior: smooth;
}

/* Generic parallax layout */
.parallax-section {
position: relative;
height: 100vh;
background-attachment: fixed;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}

h2 {
    padding-top: 0.7rem;
    padding-bottom: 0.7rem;
    text-decoration: underline;
}

.section-content {
position: relative;
z-index: 1;
}

.parallax-section::before {
content: '';
position: absolute;
inset: 0;
/* background-color: rgba(0, 0, 0, 0.4); Optional dark overlay */
z-index: 0;
}

/* Background images for each section */
.parallax-bg {
background-image: url('https://images.pexels.com/photos/1267320/pexels-photo-1267320.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
background-attachment: fixed;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}

.ingredients-bg {
background-image: url('https://images.pexels.com/photos/2762930/pexels-photo-2762930.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
}

.instructions-bg {
background-image: url('https://images.pexels.com/photos/7172069/pexels-photo-7172069.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
}

.details-bg {
background-image: url('https://images.pexels.com/photos/3806986/pexels-photo-3806986.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
}
</style>


  

<script setup>
import { defineProps } from 'vue'
import facebook from '@/Pages/images/facebook.png'
import instagram from '@/Pages/images/instagram.png'
import { Link } from '@inertiajs/vue3'


// Define the props
const props = defineProps({
  recipe: Object,
  user: Object,
});
const { recipe, user } = props;
const { ingredients,instructions,recipeDetail } = recipe





const groupedIngredients = {
  noGroup: [],
  byGroup: {}
};
ingredients.forEach(item => {
  if (!item.group) {
    groupedIngredients.noGroup.push(item);
  } else {
    if (!groupedIngredients.byGroup[item.group]) {
      groupedIngredients.byGroup[item.group] = [];
    }
    groupedIngredients.byGroup[item.group].push(item);
  }
});






</script>

  