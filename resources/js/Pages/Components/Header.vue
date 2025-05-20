<template>
<div class="header border flex flex-col" style="font-family: Playwrite DK Loopet, cursive;" >
    <div class="navbar relative bg-base-100 shadow-sm px-6 border"> 
    
      <!-- Logo / Title -->
      <div class="w-[60%] md:w-[25%] bg-inherit">
        <Link href="/" class="w-full btn btn-ghost justify-start text-left lg:text-lg">
        <span style="font-family: Playwrite DK Loopet, cursive;" class="text-[1.3rem]">Spice</span><span class="text-red-600">Rack</span>
        </Link>
      </div>
  
      <!-- Right Side Controls -->
      <div class="flex-none flex items-center gap-3 w-[40%] md:w-[75%]">
 
     
  
        <!-- Heart Icon (Favorites) with Small Badge -->
        <Link href="/likes" class="btn btn-ghost btn-circle relative ml-auto">
          <img :src="heartIcon" alt="Favorites" class="w-5 h-5" />
          <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">
            {{ likes }}
          </span>
        </Link>
  
        <!-- User Avatar Dropdown -->
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
              <img alt="User avatar" :src="user ? user.profile_image_url : shubaDuck" />
            </div>
          </div>
          <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
            <li v-if="user">
              <Link  href="/dashboard" class="justify-between">
                Profile
              </Link>
            </li>
            <li v-if="user"><Link href="/logout" method="post">Logout</Link></li>
            
            <li v-if="!user"><Link  href="/login">Sign In</Link></li>
            <li v-if="!user"><Link  href="/register">Register</Link></li>
          </ul>
        </div>
      </div>

    </div>

        <!-- Search -->
    <div class="items-center flex  w-full">
            <SearchRecipe />
    </div>
</div>
<div>

</div>


</template>
  
<script setup>
import shubaDuck from '@/Pages/images/Shuba-duck-1702738417533.png'
import heartIcon from '@/Pages/images/heart.svg'
import emitter from '@/Pages/Utils/EventBus'
import { Link } from '@inertiajs/vue3';
import { ref,onMounted } from 'vue';
import axios from 'axios'
import SearchRecipe from '@/Pages/Components/SearchRecipe.vue';



const {user} = defineProps({
  user: {
    type: [Object, String],
    default: ''
  }
})

const setUserLike = ()=>{
  
}
const likes = ref(0)
onMounted(() => {
  emitter.on('likeStatusChanged', async (newCount) => {
    if(user == null) return
    if(user.id === undefined || user === "") return
    const count = await getUserLikeCount(user.id);
    likes.value = count;
  });
});



async function getUserLikeCount(userId) {
  if(user === null) return
  if(userId === undefined || userId === '') return
  try {
    const response = await axios.get('/likes/count', {
      params: {
        user_id: userId
      }
    });
    
    return response.data.like_count;
    
  } catch (error) {
    console.error('Error fetching like count:');
    
    if (error.response) {
      // Server responded with error status (4xx, 5xx)
      console.error('Response data:', error.response.data);
      console.error('Status code:', error.response.status);
    } else if (error.request) {
      // No response received
      console.error('No response received');
    } else {
      // Request setup error
      console.error('Request error:', error.message);
    }
    
    throw error; // Re-throw to let the caller handle it
  }
}
async function showLikeCount() {
  if(user === null || user === '') {
    return
  }
  try {
    const count = await getUserLikeCount(user.id);
    likes.value = count;
  } catch (error) {
    console.error('Failed to load like count:', error);

  }
}
showLikeCount();





</script>
