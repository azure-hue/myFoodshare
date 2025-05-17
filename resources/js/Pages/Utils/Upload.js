import axios from 'axios'




export async function uploadFile(file,status) {
    if (!file) {
        alert('No file selected!')
        return
      }
      const formData = new FormData()
      formData.append('file', file)
      formData.append('folder',status.folder)
      formData.append('upload_preset','ml_default')
    

    
      try {
        const res = await axios.post('https://api.cloudinary.com/v1_1/doxoy2pdo/image/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'   ,
          },
          formData
        })
        status.image_url = res.data.secure_url
        status.image_public_id = res.data.public_id
    
    
        
      } catch(err) {
        status.errorMessage = 'Error uploading image. Please try again.'
        status.failure = true
        return 
      } finally {
        status.isUploading = false
        return 
    }
}



