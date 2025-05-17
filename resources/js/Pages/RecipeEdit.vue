<template>
    <div class="bg-gray-100">
    <nav class="flex items-center bg-gray-100 justify-center w-full bg-red gap-6 p-4 shadow-md">
        <Link :href="route('welcome')" class="text-gray-700 hover:text-blue-600"
            >Home</Link
        >
        <Link
            :href="route('dashboard')"
            class="text-gray-700 hover:text-blue-600"
            >Dashboard</Link
        >
        <Link
            :href="route('create-recipe')"
            class="text-gray-700 hover:text-blue-600"
            >Create Recipe</Link
        >
    </nav>

    <div class="max-w-3xl border mx-auto p-6 bg-white shadow-md space-y-6">
        <!-- Recipe Info -->
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold">Edit Recipe</h2>

            <div>
                <label class="block text-sm font-medium">Recipe Name</label>
                <input
                    v-model="formData.name"
                    type="text"
                    class="w-full border rounded p-2 mt-1"
                />
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea
                    v-model="formData.description"
                    class="w-full border rounded p-2 mt-1"
                    rows="4"
                ></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Image Upload</label>
                <input
                    type="file"
                    @change="handleImageUpload"
                    class="w-full mt-1"
                />
                <p class="text-xs text-gray-500 mt-1">
                    Current: {{ recipe.recipeDetail.image?.image_url }}
                </p>
            </div>
        </div>

        <!-- Ingredients Section -->
        <div>
            <h3 class="text-xl font-semibold mb-2">Ingredients</h3>

            <!-- Header Labels -->
            <div
                class="grid grid-cols-4 gap-2 text-sm font-medium text-gray-700 mb-1 px-1"
            >
                <label>Amount</label>
                <label>Unit</label>
                <label>Group</label>
                <label>Ingredient</label>
            </div>

            <!-- Ingredient Inputs -->
            <div
                v-for="(ingredient, index) in formData.ingredients"
                :key="index"
                class="grid grid-cols-4 gap-2 mb-2"
            >
                <input
                    v-model="ingredient.amount"
                    placeholder="e.g. 2"
                    class="border p-2 rounded"
                />
                <input
                    v-model="ingredient.unit"
                    placeholder="e.g. cups"
                    class="border p-2 rounded"
                />
                <input
                    v-model="ingredient.group"
                    placeholder="e.g. Wet"
                    class="border p-2 rounded"
                />
                <input
                    v-model="ingredient.ingredient"
                    placeholder="e.g. Milk"
                    class="border p-2 rounded"
                />
            </div>

            <button
                @click="addIngredient"
                class="text-sm text-blue-600 hover:underline"
            >
                + Add Ingredient
            </button>
        </div>

        <!-- Instructions Section -->
        <div>
            <h3 class="text-xl font-semibold mb-2">Instructions</h3>
            <div
                v-for="(step, index) in formData.instructions"
                :key="index"
                class="flex items-start gap-2 mb-2"
            >
                <span class="font-semibold">{{ index + 1 }}.</span>
                <textarea
                    v-model="formData.instructions[index]"
                    class="flex-1 border rounded p-2"
                    rows="2"
                ></textarea>
                <button
                    @click="removeInstruction(index)"
                    class="text-red-500 hover:underline"
                >
                    Remove
                </button>
            </div>
            <button
                @click="addInstruction"
                class="text-sm text-blue-600 hover:underline"
            >
                + Add Instruction
            </button>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button
                @click="submitRecipe"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded"
            >
                Save Recipe
            </button>
        </div>
    </div>
</div>
</template>

<script setup>
import { reactive } from "vue";
import { uploadFile } from "@/Pages/Utils/Upload.js";
import { showSuccessToast, axiosErrorToast } from "@/Pages/Utils/Toast.js";
import { LoaderSpinner } from "@/Pages/Utils/LoaderSpinner";
import { deleteImage } from "@/Pages/Utils/DeleteImage.js";
import { usePage } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { Link } from '@inertiajs/vue3'



const user = usePage().props.auth.user;

const props = defineProps({
    recipe: Object, // Contains ingredients, instructions, recipeDetail
});

// Prepare editable local state (copied from props)
const formData = reactive({
    name: props.recipe.recipeDetail?.name || "",
    description: props.recipe.recipeDetail?.description || "",
    imageFile: null,
    ingredients: props.recipe.ingredients?.map((item) => ({ ...item })) || [],
    instructions: props.recipe.instructions?.slice() || [],
});

// Image file handler (not a URL input anymore)
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    formData.imageFile = file;
    console.log("Selected image file:", file);
};

const addIngredient = () => {
    formData.ingredients.push({
        amount: "",
        unit: "",
        group: "",
        ingredient: "",
    });
};

const addInstruction = () => {
    formData.instructions.push("");
};

const removeInstruction = (index) => {
    formData.instructions.splice(index, 1);
};
const uploadImg = async () => {
    const status = {
        folder: "recipes-upload",
        isUploading: true,
        errorMessage: "",
        failure: false,
        image_url: null,
        image_public_id: null,
    };

    if (status.isUploading) {
        LoaderSpinner(); // assuming this is a visual indicator
    }

    const image = formData.imageFile;

    try {
        await uploadFile(image, status); // correctly wait for upload to complete
    } catch (err) {
        status.failure = true;
        status.errorMessage = err.message || "Upload failed.";
    }

    if (status.failure) {
        axiosErrorToast("Failed to upload recipes!");
        return null;
    }

    Swal.close();

    const { image_url, image_public_id } = status;

    const recipeDetail = {
        name: formData.name,
        description: formData.description,
        image: {
            image_url,
            image_public_id,
        },
    };

    return recipeDetail;
};

const submitRecipe = async () => {
    const recipeDetail = await uploadImg();
    if (recipeDetail === null) return;
    const public_id = props.recipe.recipeDetail.image.image_public_id;
    if ((await deleteImage(public_id)) === null) {
        axiosErrorToast("Failed to Save recipe!");
        return;
    }

    const payload = {
        user_id: user.id,
        recipeDetail: recipeDetail,
        ingredients: formData.ingredients,
        instructions: formData.instructions,
    };

    console.log("Submitting edited recipe:", payload);
    try {
        const response = await axios.put(
            `/recipes/${props.recipe.id}`,
            payload
        );
        showSuccessToast();
        Inertia.reload();
    } catch (error) {
        // console.error('Update failed:', error);
        axiosErrorToast("Failed to update the recipe.");
    }
};
</script>
