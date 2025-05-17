<template>


        <div  class="rounded-lg   grid auto-rows-[30%] overflow-y-auto gap-[4rem]">
            <div class=" mt-[1rem]  flex flex-col  rounded-lg" v-for="(ingredient,index) in ingredients" :key="index">
                    <label class="bg-black bg-opacity-40 text-center text-white">Ingredient: {{ index }}</label>
                    <input class=" border-none " v-model="ingredient.ingredient" placeholder="Ingredient" />
                    <!-- amount -->
                        <div class="grid grid-cols-[80%,20%] h-full border-none">
                            <input placeholder="Amount" v-model="ingredient.amount" class=" border-none" />
                            <select class=" border-none text-white bg-black bg-opacity-40" v-model="ingredient.unit" id="fruit" name="fruit">
                                <option value="">unit</option>
                                <option value="cup">cup</option>
                                <option value="g">g</option>
                                <option value="lb">lb</option>
                                <option value="tbsp">tbsp</option>
                                <option value="tsp">tsp</option>
                                <option value="small">small</option>
                                <option value="medium">medium</option>
                                <option value="large">large</option>
                                <option value="inch">inch</option>
                            </select>
                        </div>
                    <!-- prep notes -->

                    <input v-model="ingredient.group" class="w-full border-none" type="text" placeholder="Enter the prep (chopped,sliced,etc)" />     
                    <button @click="removeIngredient(index)" class="btn bg-black bg-opacity-40 border-none text-white">remove</button>

            </div>

        </div>

        <!-- You can open the modal using ID.showModal() method -->
        <button class="rounded-lg p-2 text-lg  w-full text-white bg-black bg-opacity-30 " onclick="my_modal_3.showModal()"><span class="p-2">+</span>Add ingredients</button>
        <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
    
            <div class="flex flex-col mb-4 ">
                <label>Ingredients</label>
                <input v-model="ingredientHelper.ingredient" type="text" class="rounded-lg  border-gray-200" />
            </div>
            <div class="flex flex-col mb-4 ">
                <label>Amount</label>
                <div>
                    <input v-model="ingredientHelper.amount" type="number" class="rounded-lg input border-gray-200" />
                    <select v-model="ingredientHelper.unit" class="rounded-lg border-gray-200" id="fruit" name="fruit">
                        <option value="">unit</option>
                        <option value="cup">cup</option>
                        <option value="g">g</option>
                        <option value="lb">lb</option>
                        <option value="tbsp">tbsp</option>
                        <option value="tsp">tsp</option>
                        <option value="small">small</option>
                        <option value="medium">medium</option>
                        <option value="large">large</option>
                        <option value="inch">inch</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col mb-4 ">
                <label>Ingredient group</label>
                <input  type="text" v-model="ingredientHelper.group" placeholder="Enter the ingredient group" class="rounded-lg border-gray-200" />
            </div>
            <button @click="addIngredient" class="btn btn-block btn-success text-white " onclick="my_modal_3.close()">Add</button>
            <div>

            </div>
        </div>
        </dialog>
    
</template>


<script setup>
import { ref } from 'vue'
import { showErrorToast } from '@/Pages/Utils/Toast.js'

const emit = defineEmits(['update-ingredients'])

const ingredients = ref([])
const ingredientHelper = ref([
{ 
    ingredient: '', 
    amount: '', 
    unit: '', 
    group: '' 
  }
])

const addIngredient = ()=>{
    if(ingredientHelper.value.unit === undefined || ingredientHelper.value.ingredient === undefined || ingredientHelper.value.amount === undefined ) {
        showErrorToast()
        return
    }
    for(const key in ingredientHelper.value){
        if(ingredientHelper.value[key] == '' && key !== 'group') {
            showErrorToast()
            return
        }
    }
    ingredients.value.push({ ingredient: ingredientHelper.value.ingredient, amount: ingredientHelper.value.amount, unit: ingredientHelper.value.unit, group: ingredientHelper.value.group})
    ingredientHelper.value = { ingredient: '', amount: '', unit: '', group: '' }
    emit('update-ingredients', ingredients.value)
}

const removeIngredient = (index) => {
    ingredients.value.splice(index, 1)
    emit('update-ingredients', ingredients.value)
}



</script>

<style scoped>
input {
    @apply focus:outline-none focus:ring-0 text-white focus:border-gray-300 p-2 bg-black bg-opacity-30;
}
</style>