<template>
    <div class="grid grid-rows-[10%,80%,10%] mt-2 ">
        <h2 class="text-white bg-black  bg-opacity-40">
            Add Recipe Image
        </h2>
        <div class="rounded-lg border">
            <img :src="recipeDetails.image ? setImg : foodIcon"  class="m-auto rounded-lg h-full  w-[45%]"/>
        </div>
        <div class="bg-black  bg-opacity-15">
            <input  @change="setImage" name="image" type="file"  
            class="w-full 
            file:border-0 file:bg-inherit file:h-full file:text-white  bg-black bg-opacity-30
            h-full
            "/>
        </div>
    </div>
    
    <div class="flex flex-col bg-black bg-opacity-40">
        <h2 class="  text-white  bg-inherit">
            Recipe Name
        </h2>
        <input placeholder="recipe name" @change="setChangeName" v-model="recipeDetails.name" class="input text-white w-full border-none bg-black bg-opacity-30" type="text" />
    </div>

    <div class="grid grid-rows-[30%,70%] bg-black bg-opacity-40">
        <h2 class="text-white bg-black bg-opacity-30">
            Recipe Description
        </h2>
        <textarea @change="setChangeDesc" v-model="recipeDetails.description" class="w-full textarea textarea-success resize-none  border-none bg-black bg-opacity-20 text-white"></textarea>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import foodIcon from '@/Pages/images/vegetable.png'


const emit = defineEmits(['update-recipe-details'])


const recipeDetails = ref({
    name: '',
    description: '',
    image: null,
})
const setImg = ref(null)

const setImage = (event) => {
    const file = event.target.files[0]
    if(!file) {
        setImg.value = foodIcon
        return
    }
    setImg.value = URL.createObjectURL(file) 
    recipeDetails.value.image = file; 
    emit('update-recipe-details', recipeDetails.value);

}
const setChangeName = (event) => {
    recipeDetails.value.name = event.target.value
    emit('update-recipe-details', recipeDetails.value)
}
const setChangeDesc = (event) => {
    recipeDetails.value.description = event.target.value
    emit('update-recipe-details', recipeDetails.value)
}


</script>

<style scoped>


h2 {
    @apply p-1;
}

</style>