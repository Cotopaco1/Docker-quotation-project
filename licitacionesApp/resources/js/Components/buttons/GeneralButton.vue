<script setup>
    defineProps({
        label: {
            type: String,
            required: true
        },
    });
</script>
<template>
    <button class="button">{{ label }}</button>
</template>