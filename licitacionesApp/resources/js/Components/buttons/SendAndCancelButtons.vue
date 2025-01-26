<script setup>
    import RedButton from './RedButton.vue';
    import SendButton from './SendButton.vue';
    const emit = defineEmits(['delete']);
</script>
<template>
    <div class="flex gap-4 my-10">
        <RedButton @click="emit('delete')" label="Eliminar" />
        <SendButton/>
    </div>
</template>