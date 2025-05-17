<template>
  <div class="rounded-2xl bg-white shadow-md overflow-hidden flex flex-col relative">
    <!-- Food Image -->
    <img :src="imageUrl" alt="Recipe Image" class="h-48 w-full object-cover" />

    <!-- Favorite Heart Icon -->
    <button @click="toggleLike" class="absolute top-3 right-3 text-red-500">
      <svg v-if="isFavorited" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
        <path
          d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.41 4.42 3 
             7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 
             14.76 3 16.5 3 19.58 3 22 5.41 
             22 8.5c0 3.78-3.4 6.86-8.55 
             11.54L12 21.35z"
        />
      </svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M4.318 6.318a4.5 4.5 0 010 6.364L12 20.364l7.682-7.682a4.5 
             4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
             4.5 0 00-6.364 0z" />
      </svg>
    </button>

    <!-- Card Content -->
    <div class="p-4 flex flex-col gap-2 flex-1">
      <!-- Recipe Title & Avatar -->
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">{{ name }}</h2>
        <span class="text-red-500 sm:mr-2">{{ chefName }}</span>
        <img :src="chefImageUrl" alt="User Avatar" class="w-8 h-8 rounded-full" />
      </div>

      <!-- Scrollable Description -->
      <div class="overflow-y-auto max-h-24 text-sm text-gray-600">
        <p>{{ description }}</p>
      </div>

      <!-- View Button -->
      <button @click="viewRecipe"
        style="background-color: #0b3953;"
        class="mt-auto hover:bg-indigo-700 text-white text-sm py-2 px-4 rounded-xl w-full">
        View Recipe
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import emmiter from '@/Pages/Utils/EventBus'
import fetchChefProfile from '@/Pages/Utils/FetchChef'

// ✅ Use camelCase in defineProps
const props = defineProps({
  description: String,
  name: String,
  imageUrl: String,
  userId: Number,
  recipeId: Number,
  chefId: Number,
})


const isFavorited = ref(false)

const checkLikeStatus = async () => {
  if (props.userId === undefined) {
    return
  }

  try {
    const response = await axios.get('/like/liked-recipe', {
      params: {
        user_id: props.userId,
        recipe_id: props.recipeId,
      },
    })

    return response.data.liked
  } catch (error) {
    console.error('Error checking like:', error)
    return false
  }
}

checkLikeStatus().then((liked) => {
  isFavorited.value = liked
})

// ✅ Use camelCase refs
const chefImageUrl = ref('')
const chefName = ref('')

const fetchChef = async () => {
  try {
    const response = await fetchChefProfile(props.chefId)
    const { name, profile_image_url } = response.data
    chefImageUrl.value = profile_image_url
    chefName.value = name
  } catch (error) {
    console.error('Error fetching chef profile:', error)
  }
}

fetchChef()

const toggleFavorite = () => {
  if (props.userId === null) {
    alert('Please log in to favorite recipes.')
    return
  }
  isFavorited.value = !isFavorited.value
  console.log(isFavorited.value ? 'Added to favorites' : 'Removed from favorites')
}

const viewRecipe = () => {
  router.visit(route('recipes.show', {
    recipe: props.recipeId,
    query: {
      user: props.chefId,
    },
  }))
}

const toggleLike = () => {
  if (props.userId === null) {
    alert('Please log in to favorite recipes.')
    return
  }

  const payload = {
    user_id: props.userId,
    recipe_id: props.recipeId,
  }

  router.post(route('like.toggle'), payload, {
    preserveScroll: true,
    onSuccess: () => {
      console.log('✅ Toggled like state!')
      toggleFavorite()
    },
    onError: (errors) => {
      console.error(errors)
    },
  })

  emmiter.emit('likeStatusChanged', 'changed')
}
</script>
