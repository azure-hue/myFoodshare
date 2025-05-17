<template>
  <footer class="relative footer footer-horizontal footer-center bg-base-200 text-base-content rounded p-10 font-serif flex flex-col md:flex-col md:justify-between md:items-start">
    


    <!-- Navigation Links -->
    <nav class="grid grid-flow-col gap-6 text-sm mb-6 md:mb-0">
      <a class="link link-hover">Discover Recipes</a>
      <a class="link link-hover">Submit Your Recipe</a>
      <a class="link link-hover">Meet the Chefs</a>
      <a class="link link-hover">Help & Support</a>
    </nav>

    <!-- Social Icons -->
    <div class="mb-6 md:mb-0 p-2">
      <div class="grid grid-flow-col gap-4">
        <a href="#" aria-label="Twitter" class="hover:scale-110 transition">
          <img :src="instagram" alt="Facebook" class="w-6 h-6 rounded-full object-cover" />
        </a>
        <a href="#" aria-label="YouTube" class="hover:scale-110 transition">
          <img :src="youtube" alt="Facebook" class="w-6 h-6 rounded-full object-cover" />
        </a>
        <a href="#" aria-label="Facebook">
          <img :src="facebook" alt="Facebook" class="w-6 h-6 rounded-full object-cover" />
        </a>
      </div>
    </div>

    <!-- Copyright -->
    <aside class="text-xs opacity-70">
      <p>© {{ new Date().getFullYear() }} RecipeMate — Crafted with ❤️ for food lovers</p>
    </aside>
    
    <img :src="cookbook" alt="Sample" class=" absolute right-0  bottom-20 w-[8rem] h-[8rem] sm:bottom-0 sm:w-[12rem] sm:h-[12rem]  lg:right-[300px] object-cover" />
    <img :src="cookbook1" alt="Sample" class=" absolute bottom-20 left-0 sm:left-3 w-[8rem] h-[8rem]  lg:left-[300px] sm:bottom-0 sm:w-[12rem] sm:h-[12rem] object-cover" />


  </footer>
</template>


<script setup>
import facebook from "@/Pages/images/facebook.png"
import instagram from "@/Pages/images/instagram.png"
import youtube from "@/Pages/images/youtube.png"
import cookbook from "@/Pages/images/cookbook.webp"
import cookbook1 from "@/Pages/images/cookbook1.webp"

</script>

<style scoped>
*{
  font-family: Playwrite DK Loopet, cursive;
}
</style>