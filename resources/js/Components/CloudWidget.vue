<template>
        <button class="btn btn-accent text-white" @click="openUploadWidget">Upload</button>
</template>

<script setup>

const emit = defineEmits();


const widget = window.cloudinary.createUploadWidget(
  {cloud_name: 'doxoy2pdo', upload_preset: 'ml_default'},
  (error,result)=>{
    if(!error && result && result.event === 'success') {
      console.log('Done uploading', result.info)
      console.log('Image URL:', result.info.secure_url)
      console.log('Image Public ID:', result.info.public_id)
      const imageData = {
        public_id: result.info.public_id,
        url: result.info.secure_url,
      }
      emit('imageData', imageData)
    }
  }
)
function openUploadWidget(){
  widget.open()
}
</script>