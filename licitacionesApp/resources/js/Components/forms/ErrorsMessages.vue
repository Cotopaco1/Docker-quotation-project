<script setup>
    const props = defineProps({
        errors: {
            type: Object,
        }
    });

</script>
<template>
    <div class="flex flex-col gap-2 my-4">
        <div v-for="error in errors" >
            <span v-for="innerError in error" class="text-red-700 bg-red-300/90 px-2 py-1">{{ innerError }}</span>
        </div>
    </div>
</template>
