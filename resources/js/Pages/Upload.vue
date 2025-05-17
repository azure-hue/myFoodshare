<script setup>
import { ref } from 'vue';
import axios from 'axios';

const fileInput = ref(null);
const uploadedUrl = ref(null);
const errorMessage = ref(null);
const uploadedPublicId = ref('');
const public_id = ref('')


async function uploadImage() {
  errorMessage.value = null;

  if (!fileInput.value.files.length) {
    errorMessage.value = 'Please select an image file.';
    return;
  }

  const formData = new FormData();
  formData.append('image', fileInput.value.files[0]);

  try {
    const response = await axios.post('/api/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    uploadedUrl.value = response.data.url;
    // uploadedPublicId.value = response.data.public_id

    public_id.value = response.data.public_id

    console.log(response.data)
    
  } catch (error) {
    errorMessage.value =
      error.response?.data?.message || 'Upload failed.';
  }
}
</script>

<template>
  <input type="file" ref="fileInput" accept="image/*" />
  <button @click="uploadImage">Upload</button>

  <p v-if="errorMessage" style="color: red">{{ errorMessage }}</p>

  <div v-if="uploadedUrl" style="margin-top: 1em;">
    <h2>Uploaded Image:</h2>
    <img :src="uploadedUrl" alt="Uploaded" style="max-width: 300px;" />
  </div>
</template>
