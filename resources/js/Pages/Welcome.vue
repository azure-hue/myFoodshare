<template>

    <Header  :user="user"/>
    <Main 
      :recipes="recipes"
      :user_id="user?.id"
      />
    <Footer />
</template>


<script setup>
import Header from '@/Pages/Components/Header.vue'
import Main from '@/Pages/Components/Main.vue'
import Footer from '@/Pages/Components/Footer.vue'


// Accept props passed from the Laravel controller
const {recipes,user} = defineProps({
  recipes: Object,
  user: Object,
})






</script>