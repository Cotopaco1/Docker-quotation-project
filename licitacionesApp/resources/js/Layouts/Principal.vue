<script setup>
    import Header from '@/Components/Header.vue';
    import { RequestService } from '@/Composables/RequestService';
    import { ref, inject } from 'vue';
    const {request} = RequestService();
    const globalState = inject('globalState');
    const props = defineProps({
            currentRoute: {
                type: String,
                required: true
            }
        })
    const version = ref('');
    function getVersion(){
        if(globalState.version !== ''){
            return;
        }
        request('/version', {}, 'GET').then((res)=>{
            globalState.version = res.version;
        })
    }
    getVersion();
</script>
<template>
    <div class="flex flex-col min-h-screen relative">
        <Header :currentRoute="props.currentRoute"/>
        <main class="flex-1 bg-primary-3 ">
            <div class="w-11/12 mx-auto  p-4 ">
                <slot />
            </div>
        </main>
        <div v-if="globalState.version !== ''">
            <p class="absolute top-0 left-0 p-1 bg-primary-5 text-white text-xs">V {{ globalState.version }}</p>
        </div>
    </div>
</template>

