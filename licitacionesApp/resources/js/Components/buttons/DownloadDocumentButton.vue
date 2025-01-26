<script setup>
    import { RequestService } from '@/Composables/RequestService';
    const { request } = RequestService();
    const props = defineProps({
        route: {
            type: String,
            required: true
        }
    });
    function getFile(){
        window.location.href = props.route;
    }
</script>
<template>
    <div class="svg-medium" @click="getFile">
        <img  src="/assets/download-document.svg" alt="">
    </div>
</template>