<script setup>
const props = defineProps({
    value: String,
});
</script>

<template>
    <label class="block text-lg font-bold text-orange-400">
        <span v-if="props.value">{{ props.value }}:</span>
        <span v-else><slot />Name:</span>
    </label>
</template>
