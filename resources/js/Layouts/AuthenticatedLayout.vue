<script setup>
import { ref } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import shubaDuck from "@/Pages/images/Shuba-duck-1702738417533.png";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { SuccessToast,ConfirmToast } from "@/Pages/Utils/Toast";

           

const user = usePage().props.auth.user;

const showingNavigationDropdown = ref(false);








const getGreeting = () => {
    const hour = new Date().getHours();

    if (hour < 12) return "Good morning";
    if (hour < 18) return "Good afternoon";
    return "Good evening";
};

const userId = user.id;

const recipes = ref([]);
const pagination = ref({
    current_page: 1,
    last_page: 1,
});

const fetchRecipes = async (page = 1) => {
    try {
        const res = await axios.get(`/user/${userId}/recipes?page=${page}`);
        recipes.value = res.data.data;
        pagination.value.current_page = res.data.current_page;
        pagination.value.last_page = res.data.last_page;

    } catch (error) {
        console.error("Failed to fetch recipes:", error);
    }
};

// Initial fetch
onMounted(() => {
    fetchRecipes();
});



const deleteRecipe = async (id) => {
    try {
        ConfirmToast("Are you sure you want to delete this recipe?")

        await axios.delete(`/recipes/${id}`);
        SuccessToast(`Recipe ${id} deleted successfully`);

    } catch (error) {
        console.error("Error deleting recipe:", error);
    }
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('welcome')">
                                    <img
                                        class="h-12 w-12"
                                        :src="shubaDuck"
                                        alt="Shuba Duck Logo"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    <span
                                        style="
                                            font-family: Playwrite DK Loopet,
                                                cursive;
                                        "
                                        class="text-[1.3rem]"
                                        >Spice</span
                                    ><span class="text-red-600">Rack</span>
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                <img
                                                    :src="
                                                        $page.props.auth.user
                                                            .profile_image_url
                                                    "
                                                    alt="User profile picture"
                                                    class="w-10 mr-1 h-10 rounded-full object-cover border shadow-sm"
                                                />
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('create-recipe')"
                                        >
                                            Create Recipe
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pb-1 pt-4">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('create-recipe')">
                                Create Recipe
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow flex" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <img
                        :src="$page.props.auth.user.profile_image_url"
                        alt="User profile picture"
                        class="w-12 mr-1 h-12 rounded-full object-cover border sm:hidden shadow-sm"
                    />
                </div>
                <div class="flex items-center w-full">
                    <h1 class="text-2 font-bold text-center">
                        <span
                            style="font-family: Playwrite DK Loopet, cursive"
                            class="text-red-500"
                            >{{ getGreeting() }}</span
                        >
                        {{ $page.props.auth.user.name }}...
                    </h1>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="w-full lg:w-[80%] mx-auto p-4">
                    <h2 class="text-2xl font-bold mb-4">All Recipes</h2>

                    <div
                        v-for="(recipe, index) in recipes"
                        :key="index"
                        class="flex items-center justify-between bg-white p-4 mb-3 rounded shadow"
                    >
                        <!-- Image -->
                        <img
                            :src="recipe.recipeDetail.image.image_url"
                            alt="Recipe image"
                            class="w-16 h-16 object-cover rounded-full mr-4"
                        />

                        <!-- Recipe Name -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">
                                {{ recipe.recipeDetail.name }}
                            </h3>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <Link
                                :href="route('recipes.edit', { recipe: recipe.id })"
                                class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded"
                            >
                                Edit
                            </Link>
                            <button
                                class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded"
                                @click="deleteRecipe(recipe.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pagination Buttons -->
                <div
                    class="flex justify-center mt-6 space-x-2"
                    v-if="pagination.last_page > 1"
                >
                    <button
                        @click="fetchRecipes(pagination.current_page - 1)"
                        :disabled="pagination.current_page === 1"
                        class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded disabled:opacity-50"
                    >
                        Prev
                    </button>
                    <button
                        v-for="page in pagination.last_page"
                        :key="page"
                        @click="fetchRecipes(page)"
                        :class="[
                            'px-3 py-1 rounded',
                            page === pagination.current_page
                                ? 'bg-blue-500 text-white'
                                : 'bg-gray-200 hover:bg-gray-300',
                        ]"
                    >
                        {{ page }}
                    </button>

                    <button
                        @click="fetchRecipes(pagination.current_page + 1)"
                        :disabled="
                            pagination.current_page === pagination.last_page
                        "
                        class="px-3 py-1 bg-gray-300 hover:bg-gray-400 rounded disabled:opacity-50"
                    >
                        Next
                    </button>
                </div>
                <!-- Profile edit/delete stuffs  -->
                <slot />
                <!-- Profile edit/delete stuffs  -->
            </main>
        </div>
    </div>
</template>
