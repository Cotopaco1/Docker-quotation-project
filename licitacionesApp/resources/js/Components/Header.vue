<script setup>
import Link from '@/Components/header/link.vue';
import { computed, defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { alerError } from '@/Composables/AlertService';

import { RequestService } from '@/Composables/RequestService';
const {request} = RequestService();
const props = defineProps({
    currentRoute: {
        type: String,
        required: true
    }
})

const isProductosRoute = computed(() => props.currentRoute === 'productos');
const isProveedoresRoute = computed(() => props.currentRoute === 'proveedores');
const isCotizacionesRoute = computed(() => props.currentRoute === 'cotizaciones');

const showAccountDetails = ref(false);

function logout(){
    request('/logout', {}, 'POST')
    .then(() => {
        router.visit('/login', { method: 'get', preserveState: false, replace: true });
    })
    .catch(err => {
        alerError(err.response.data.message);
    });
}
</script>

<template>
    <div class="w-full bg-primary-3  flex py-10">
        <nav class="flex w-11/12 mx-auto justify-between align-center bg-primary-5">
            <Link link="/productos" text="Productos" :active="isProductosRoute"/>
            <Link link="/proveedores" text="Proveedores" :active="isProveedoresRoute" />
            <Link link="/cotizaciones" text="Cotizaciones" :active="isCotizacionesRoute" />
            <div class="relative">
                <div  @click="showAccountDetails = !showAccountDetails" class="h-full w-full px-4 flex items-center hover:bg-primary-6 cursor-pointer" :class="{active: showAccountDetails}">
                    <span class="">Cuenta</span>
                </div>
                <div v-if="showAccountDetails" class="absolute -bottom-12 left-0 bg-white p-2 w-20  rounded-xl z-10">
                    <ul >
                        <li @click="logout" class="cursor-pointer hover:bg-primary-2 py-1 px-2 rounded">Logout</li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<style scoped>  
    .active {
        @apply bg-primary-6;
    }
</style>