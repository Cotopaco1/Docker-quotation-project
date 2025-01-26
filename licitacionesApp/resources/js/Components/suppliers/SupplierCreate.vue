<script setup>
    import { ref } from 'vue';
    import SupplierForm from '../forms/SupplierForm.vue';
    import ModalCustom from '../ModalCustom.vue';
    import SendButton from '../buttons/SendButton.vue';
    import ErrorsMessages from '../forms/ErrorsMessages.vue';
    import Swal from 'sweetalert2';
    import { RequestService } from '@/Composables/RequestService';

    const { request, errors} = RequestService();
    const props = defineProps({
        showModal: Boolean
    });
    const emit = defineEmits(['close', 'updated']);

    const supplier = ref({
        name: '',
        identification: '',
        phone: '',
        city: '',
        website: '',
        address: ''
    });

    function createSupplier(){
        request('/supplier', supplier.value, 'POST', false)
            .then(() => {
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Proveedor creado!",
                showConfirmButton: false,
                timer: 1500
                });
                emit('updated');
                emit('close');
            });
    }
    

</script>
<template>
    <ModalCustom title="Crear Proveedor" v-if="showModal" @close="emit('close')">
        <form @submit.prevent="createSupplier">
            <ErrorsMessages :errors="errors"/>
            <SupplierForm :supplier="supplier"/>
            <div>
                <SendButton/>
            </div>
        </form>
    </ModalCustom>
</template>