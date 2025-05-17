<template>
    <div class="relative m-auto w-full flex lg:w-[90%]">
      <input
        v-model="query"
        @keydown.enter="handleSearch"
        type="text"
        placeholder="Search recipes..."
        class="w-full input input-bordered"
      />
      <button
       @click="handleSearch"
       class="btn btn-md text-[0.7rem] w-[20%] lg:w-[10%] btn-outline btn-success"
       >Search</button>
    </div>
  </template>
  

  <script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const query = ref('')

const handleSearch = () => {
  if (query.value.trim() === '') return
  
  router.get('/recipes/search', { query: query.value })
}
</script>
