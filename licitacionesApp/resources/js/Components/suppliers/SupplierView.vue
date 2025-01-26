<script setup>
    import { ref, toRef } from 'vue';
    import SupplierForm from '../forms/SupplierForm.vue';
    import ModalCustom from '../ModalCustom.vue';
    import SendButton from '../buttons/SendButton.vue';
    import ErrorsMessages from '../forms/ErrorsMessages.vue';
    import Swal from 'sweetalert2';
    import RedButton from '../buttons/RedButton.vue';
    import { RequestService } from '@/Composables/RequestService';
    import { alertSuccess } from '@/Composables/AlertService';

    const emit = defineEmits(['close', 'updated']);
    const props = defineProps({
        showModal: Boolean,
        modelValue: Object,
    })
    const {request, errors} = RequestService();
    const supplier = toRef(props, 'modelValue');

    function updateSupplier(){
        request(`/supplier/${supplier.value.id}`, supplier.value, 'PUT', false).then(response => {
            alertSuccess('Proveedor actualizado!');
            emit('close');
            emit('updated');
        });
    }
    function confirmAlert(){
        Swal.fire({
            title: "Quieres eliminar el proveedor #"+ supplier.value.id+"?",
            showCancelButton: true,
            icon: 'warning',
            confirmButtonText: "Eliminar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            }).then((result) => {
            if (result.isConfirmed) {
                //Request to delete supplier
                deleteSupplier();
            } 
            });
    }
    function deleteSupplier(){
        request('/supplier/'+supplier.value.id, {}, 'DELETE', true).then(response => {
            alertSuccess('Proveedor eliminado!');
            emit('close');
            emit('updated');
        });
    }
</script>
<template>
    <ModalCustom title="Crear Proveedor" v-if="showModal" @close="emit('close')">
        <form @submit.prevent="updateSupplier">
            <ErrorsMessages :errors="errors"/>
            <SupplierForm :supplier="supplier"/>
            <div class="flex gap-4">
                <RedButton @click="confirmAlert" type="button" label="Eliminar"/>
                <SendButton/>
            </div>
        </form>
    </ModalCustom>
</template>