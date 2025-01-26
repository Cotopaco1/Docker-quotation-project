<script setup>
    import {Link} from '@inertiajs/vue3';

    const props = defineProps({
        link: String,
        text: String,
        active: Boolean,
    });

</script>
<template>
    <Link :href="props.link" 
        class="px-6 py-4 flex justify-center items-center flex-1 hover:bg-primary-6" 
        :class="{'active': active}"

    >
        <span class="font-bold" > {{ props.text }} </span>
    </Link>
</template>

<style scoped>
    .active {
        @apply bg-primary-6;
    }
    .active span{
        @apply text-primary-1;
    }
</style>