<template>

    <div class="border rounded-lg pb-[2rem]">
        <h2 class="text-2xl text-green-500 font-bold text-center mt-4">{{ recipes.name }}</h2>
        <!-- Recipe Image -->
        <img 
        :src="recipes.image" 
        alt="Recipe Image"
        class="w-[75%] m-auto  object-cover rounded-xl border border-gray-200"
        />
    </div>
    <div>
        <h2 class="text-2xl font-bold text-center mt-4">Description</h2>
        <h3 class="text-white bg-black bg-opacity-50  lg:w-3/4 p-3 text-lg m-auto">{{ recipes.description }}</h3>
    </div>

    <h2 class="text-2xl font-bold text-center mt-4">Ingredients</h2>
    <div class="grid place-items-center  gap-[2rem] pt-[2rem] pb-[2rem] bg-black bg-opacity-50">
        <div class=" w-[80%] rounded-lg p-2" v-for="items in recipes.ingredient">
            <p class="pl-[1rem] ">{{ items.amount }} {{ items.unit }}</p>
            <p class="pl-[1rem] ">{{ items.ingredient }}</p>
            <p class="pl-[1rem]">{{ items.prepNotes }}</p>
        </div>
    </div>

    <div>
        <h2 class="text-2xl font-bold text-center mt-4 ">Instructions</h2>
        <ul class="mt-[2rem] mb-[4rem] w-[80%] m-auto rounded-xl  ">
            <li 
                v-for="(instruction, index) in recipes.instructions" 
                :key="index"
                class="px-4 py-3 bg-black bg-opacity-50  flex items-start gap-2"
            >
                <span class="text-green-500">🍽️</span>
                <span class="text-gray-700 text-white ">{{ instruction }}</span>
            </li>
        </ul>
    </div>


</template>

<script setup>
const props = defineProps({
  recipes: {
    type: Object,
    required: true
  }
})



</script>


<style scoped>
p {
    @apply text-lg capitalize text-white;
}

h2 {
    @apply text-white capitalize p-2 bg-black bg-opacity-40;
}



</style>