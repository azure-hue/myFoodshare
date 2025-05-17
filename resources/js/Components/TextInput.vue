<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    labelName: String,
    error: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="w-full border-none">
        <input
        class="w-full p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        v-model="model"
        ref="input"
        :placeholder="placeholder"
    />
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>

</template>
