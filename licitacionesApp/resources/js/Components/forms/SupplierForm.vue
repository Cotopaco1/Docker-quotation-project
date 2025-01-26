<script setup>
    import InputTextForm from './InputTextForm.vue';

    const props = defineProps({
        supplier: Object,
    })
    console.log(props.supplier);
</script>
<template>
    <div class="form-content">
        <InputTextForm label="Nombre" v-model="supplier.name"/>
        <div class="group" >
            <InputTextForm label="NIT" v-model="supplier.identification"/>
            <InputTextForm label="Teléfono" v-model="supplier.phone"/>
        </div>
        <div class="group">
            <InputTextForm label="Ciudad" v-model="supplier.city"/>
            <InputTextForm label="Website" v-model="supplier.website"/>
        </div>
        <InputTextForm label="Direccion" v-model="supplier.address"/>
    </div>
</template>
<style scoped>
.group{
    @apply flex gap-4;
}
.group > * {
    @apply flex-1;
}
</style>