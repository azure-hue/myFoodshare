// utils/deleteImage.js
import axios from 'axios';

/**
 * Deletes an image from Cloudinary via Laravel backend
 * @param {string} publicId - The public_id of the image to delete
 * @returns {Promise} Axios response
 */
export async function deleteImage(publicId) {
  if (!publicId) {
        return null
    }

  try {
    const response = await axios.post('/api/delete', {
      public_id: publicId,
    });
    return response.data;
  } catch (error) {
        return null
  }
}
