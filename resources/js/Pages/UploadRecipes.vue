<template>
<div class="w-full h-screen grid place-items-center bg-cover "
      style="background-image:url(https://images.pexels.com/photos/349609/pexels-photo-349609.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2)"
>
<div class="carousel w-full lg:w-[1400px] h-screen lg:h-[95vh] rounded-lg shadow-[0_0_0_2px_rgba(0,0,0,0.05)]">
  
<!-- slide 1 -->
  <div id="slide1" class="carousel-item relative w-full grid grid-rows-[10%,80%,10%]">
    <div class="flex flex-col">
        <a
        v-if="currentPage.value > 1" 
        @click="()=>currentPage.value--"
        href="#slide4" class="btn btn-1">❮</a>
        <h1 
        class="w-full text-[2rem] text-center bg-black bg-opacity-50">
        Recipe Details
        </h1>
        <div class="border">
          <Link href="/" class="btn btn-1 ml-2">Home</Link>
          <Link href="/dashboard" class="btn ml-2 btn-1">DashBoard</Link>
        </div>
    </div>
    <div
    class=" grid grid-rows-[60%,20%,20%]">
        <RecipeDetails @update-recipe-details="handleRecipeUpdate"/>
    </div>
    <div 
    class="flex items-center justify-center bg-black bg-opacity-50">
      <a  href="#slide2" class="btn btn-2 btn-circle">Next</a>
    </div>
   </div>

  <!-- slide 2 -->
  <div id="slide2" class="carousel-item relative w-full grid grid-rows-[10%,80%,10%]">
    <div class="header flex">
        <a href="#slide1" class="btn btn-1">❮</a>
        <h1 
        class="w-full text-[2rem] bg-black bg-opacity-50 text-center">
        Ingredients
        </h1>
    </div>
    
    <div class="content h-full border  rounded-lg grid grid-rows-[90%,10%]">
        <Ingredients @update-ingredients="handleIngredUpdate" />
    </div>
    

<!-- slide 3 -->
    <div class="border  flex items-center justify-center bg-black bg-opacity-50">
      <a href="#slide3" class="btn btn-2 btn-circle">Next</a>
    </div>
  </div>
  <div id="slide3" class="carousel-item relative w-full  grid grid-rows-[10%,80%,10%]">
    <div class="header flex  ">
        <a href="#slide2" class="btn btn-1 ">❮</a>
        <h1 
        class="w-full text-[2rem] bg-black bg-opacity-50  text-center">
        Instructions
        </h1>
    </div>
    <div class="grid grid-rows-[10%,80%,10%]">
        <Instructions @update-steps="handleStepsUpdate" />
    </div>

    <div class="flex items-center justify-center bg-black bg-opacity-50">
    <button class="btn btn-2 btn-circle btn-success" @click="finalPreview">Next</button>
    <dialog id="my_modal_4" class="modal">
      <div class="modal-box w-11/12 max-w-5xl bg-black bg-opacity-80">
        <h1 class="py-4 text-center text-black">Recipe Menu is empty!!!</h1>
        <div class="modal-action">
          <form method="dialog">
            <!-- if there is a button, it will close the modal -->
            <button class="btn btn-success">Close</button>
          </form>
        </div>
      </div>
    </dialog>
    </div>
  </div>

<!-- slide 4 -->
  <div id="slide4" class="carousel-item  relative w-full  grid grid-rows-[10%,90%]">
      <div class="header flex">
          <a href="#slide3" class="btn btn-1">❮</a>
          <h1 
          class="w-full text-[2rem] bg-black bg-opacity-50 text-center">
          Preview
          </h1>
          <div class="border ">
          <Link href="/" class="btn btn-1 w-full ml-2">Home</Link>
          <Link href="/dashboard" class="btn ml-2 w-full btn-1">DashBoard</Link>
        </div>
      </div>
      <div class="shadow-md overflow-y-scroll ">
          <Preview :recipes="test" />
        <div class="h-[10vh] bg-black bg-opacity-50 flex items-center justify-center">
          <button @click="saveRecipe" class="btn btn-success btn-wide text-white text-lg">Save recipe</button>
        </div>
      </div>
  </div>

</div>
    </div>

</template>

<script setup>
import RecipeDetails from '@/Pages/Components/RecipeDetails.vue'
import Ingredients from '@/Pages/Components/Ingredients.vue'
import Instructions from '@/Pages/Components/Instructions.vue'
import Preview from '@/Pages/Components/Preview.vue'    
import { useForm,Link } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'
import foodIcon from '@/Pages/images/vegetable.png'

import {uploadFile} from '@/Pages/Utils/Upload.js'
import { showSuccessToast,axiosErrorToast } from '@/Pages/Utils/Toast.js'
import { LoaderSpinner } from '@/Pages/Utils/LoaderSpinner'
import {Inertia} from '@inertiajs/inertia'


const {userId} = defineProps({
  userId: Number
})


const currentPage = ref(1)

const recipes = useForm({
    user_id: userId,
    ingredients: [],
    instructions: [],
    recipeDetail: [],
})


const handleRecipeUpdate = (recipe) => {
    recipes.recipeDetail = recipe
}
const handleIngredUpdate = (ingredients) => {
    recipes.ingredients = ingredients
}
const handleStepsUpdate = (steps) => {
    recipes.instructions = steps
}


const test = reactive({
    name: '',
    description: '',
    image: foodIcon,

    ingredient: '',

    instructions: '',
    
})

// Save recipe
const saveRecipe = async ()=>{
  const { recipeDetail } = recipes
  const {image} = recipeDetail
  if(image == null) {
    alert('Please upload an image')
    return
  }

  const status = {
        folder: 'recipes-upload',
        isUploading: true,
        errorMessage: '',
        failure: false,
        image_url: null,
        image_public_id: null,
  }

  if(status.isUploading) {
    LoaderSpinner()
  }

  const outcome = await uploadFile(image,status)
  if(status.failure) {
    axiosErrorToast('Failed to upload recipes!')
    return
  }
  Swal.close()
  const { image_url, image_public_id } = status
  recipes.recipeDetail.image = {
    image_url: image_url,
    image_public_id: image_public_id,
  }

  recipes.post(route('recipes.store'), {
  onSuccess: () => {
    console.log('Recipe uploaded successfully')
    recipes.reset()
    Inertia.reload()
  },
  onError: () => {
    console.log('Error uploading recipe')
    recipes.reset()
  },
})
  showSuccessToast()
}


const finalPreview = ()=>{

const { ingredients,instructions,recipeDetail } = recipes
const modal = document.getElementById('my_modal_4')

  if(recipeDetail.name === undefined || recipeDetail.description === undefined || recipeDetail.image === undefined) {
    modal.showModal()
    window.location.hash = "#slide1"
    return
  }

  for(const key in recipeDetail) {
    if(recipeDetail[key] === '') {
      modal.showModal()
      window.location.hash = "#slide1"
      return
    }
  }


  if(ingredients.length === 0) {
    modal.showModal()
    window.location.hash = "#slide2"
    return
  }
  for(const item of ingredients) {
    if(item.ingredient == '' || item.amount == '' || item.unit == '') {
      modal.showModal()
      window.location.hash = "#slide2"
      return
    }
  }

  if(instructions.length === 0) {
    modal.showModal()
    window.location.hash = "#slide3"
    console.log(instructions)
    return
  }
  for(const item of instructions) {
    if(item == '') {
      modal.showModal()
      window.location.hash = "#slide3"
      return
    }
  }

  const { image, name, description } = recipeDetail 

  // recipe details
  test.image = URL.createObjectURL(image)
  test.name = name
  test.description = description

  // ingredients
  test.ingredient = ingredients

  // instructions
  test.instructions = instructions

  window.location.hash = "#slide4"

}








</script>

<style scoped>

h1 {
    @apply  text-white  font-bold;
}
.btn-2 {
    @apply  w-[40%] sm:w-[30%];
}
.btn-1 {
    @apply  h-auto bg-inherit   border-none shadow-none bg-black bg-opacity-50;
}

a {
    @apply border bg-black bg-opacity-50 border-white text-white text-[1rem];
}

</style>
