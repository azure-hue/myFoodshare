<template>
    <h1>this is recipe edit</h1>
    {{ recipe }}
</template>

<script setup>
defineProps({
    recipe: String
})
</script>