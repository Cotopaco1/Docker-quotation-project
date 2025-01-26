<script setup>
    import ProductForm from '../forms/ProductForm.vue';
    import SendAndCancelButtons from '../buttons/SendAndCancelButtons.vue';
    import ModalCustom from '../ModalCustom.vue';
    import { ref, watch, toRef } from 'vue';
    import { RequestService } from '@/Composables/RequestService';
    import { alertSuccess } from '@/Composables/AlertService';
    import Swal from 'sweetalert2';

    const { request, errors } = RequestService();
    const props = defineProps({
        modelValue: Object,
        showModal: Boolean,
    })
    const emit = defineEmits(['close', 'updated']);
    const product = toRef(props, 'modelValue');

    function updateProduct() {
        const formData = new FormData();
        if(product.value.file != null) formData.append('file', product.value.file);
        formData.append('_method', 'PUT');
        Object.entries(product.value).forEach(([key, value]) => {
            if (key === 'file') return;
            formData.append(key, value);
        });

        request(`/product/${product.value.id}`, formData, 'POST', true).then(response => {
            alertSuccess('Producto actualizado!');
            emit('close');
            emit('updated');
        });
        
    }
    function confirmAlert(){
        Swal.fire({
            title: "Quieres eliminar el producto #"+ product.value.id+"?",
            showCancelButton: true,
            icon: 'warning',
            confirmButtonText: "Eliminar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                //Request to delete product
                deleteProduct();
            } 
            });
    }  

    function deleteProduct(){
        request('/product/'+product.value.id, {}, 'DELETE', true).then(response => {
            alertSuccess('Producto eliminado!');
            emit('close');
            emit('updated');
        });
    }
   

</script>
<template>
    <ModalCustom v-if="showModal" @close="$emit('close')" :title="`Producto #`+ product?.id ?? ''">
        <form @submit.prevent="updateProduct" class="w-full mx-auto">
            <ProductForm v-model="product" :isEdit="true"/>
            <SendAndCancelButtons @delete="confirmAlert" />
        </form>

    </ModalCustom>

</template>