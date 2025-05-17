<template>
    <h2 class="p-1 text-center text-[1.5rem] bg-black bg-opacity-40 text-white">Steps</h2>
    <div class=" overflow-y-auto ">
        <div class="border flex mb-2 mt-2" v-for="(step,index) in steps" :key="index">
            <input 
            v-model="steps[index]"
            class="w-full input bg-black bg-opacity-40 text-white"
            placeholdler="Enter the step" />
            <button @click="deleteInput(index)" class="btn border-none text-white bg-black bg-opacity-40">X</button>
        </div>
    </div>
    <button @click="addStep" class="border text-[1.1rem] text-white bg-black bg-opacity-50 rounded-lg"><span>+</span> Add Step</button>

    <dialog ref="myModal" id="my_modal_1" class="modal">
    <div class="modal-box">
        <p class="py-4 text-green-400">Please fill the previous step before adding a new one!</p>
        <div class="modal-action">
        <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <button class="btn btn-success text-white">Close</button>
        </form>
        </div>
    </div>
    </dialog>
</template>

<script setup>  
import { ref } from 'vue'


const myModal = ref(null)
const activateModal = () => {
    myModal.value.showModal()
}
const steps = ref([])
const emit = defineEmits(['update-steps'])

const addStep = ()=>{
    const len = steps.value.length
    if(steps.value[len-1] == ''){
        activateModal()
        return
    }
    steps.value.push('')
    emit('update-steps', steps.value)
}

const deleteInput = (index) => {
    steps.value.splice(index, 1)
    emit('update-steps', steps.value)
}

</script>