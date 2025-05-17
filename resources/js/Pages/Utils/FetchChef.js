
export default async function fetchChefProfile(chefId) {
    try {
        const response = await axios.post(route('user.user-profile'), {
          user_id: chefId , // Send chef_id as query parameter
        });
        return response; // Return the profile image URL

    } catch (error) {
        return error.response.data; // Return the error response data
    }
}