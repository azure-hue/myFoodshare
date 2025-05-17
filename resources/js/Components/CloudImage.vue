<script setup>
import {AdvancedImage} from '@cloudinary/vue'
import {Cloudinary} from '@cloudinary/url-gen'
import { computed } from 'vue'
import { watch } from 'vue'

const cld = new Cloudinary({
  cloud: {
    cloudName: 'doxoy2pdo'
  }
})

const props = defineProps({
  imageName: String
})


const myImg = cld.image(props.imageName)



</script>

<template>
      <AdvancedImage :cldImg="myImg" />
</template>