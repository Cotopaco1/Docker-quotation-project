<script setup>
    import InputTextForm from './InputTextForm.vue';
    import InputPriceForm from './InputPriceForm.vue';
    import TextAreaForm from './TextAreaForm.vue';
    import FileUploadForm from './FileUploadForm.vue';
    import InputAutoComplete from './InputAutoComplete.vue';
    import { ref, watch } from 'vue';

    const props = defineProps({
        modelValue: {
            type: Object,
            default: {
                name: '',
                supplier: '',
                unit_price_withouth_tax: 0,
                unit_of_measure: '',
                brand: '',
                description: '',
                notes: '',
                file: '',
            }
        },
        isEdit: {
            type: Boolean,
            default: true
        }
    })

    const product = ref(props.modelValue);
    const emit = defineEmits(['update:modelValue']);

    watch(product, (newValue) => {
        emit('update:modelValue', newValue);
    });

    watch(() => props.product, (newValue) => {
        console.log(newValue);
    }, { deep: true });

</script>
<template>
    <div class="form-content">
        <InputTextForm v-model="product.name" label="Nombre" fluid/>
        <div class="flex gap-4">
            <!-- <InputTextForm v-model="product.supplier" label="Proveedor" fluid class="flex-1"/> -->
            <InputAutoComplete 
                v-model="product.supplier_id" 
                label="Proveedor" 
                class="flex-1"
                route="/list?list=supplier"
            />
            <InputPriceForm v-model="product.unit_price_withouth_tax" label="Precio unitario - sin iva" fluid class="flex-1"/>
        </div>
        <div class="flex gap-4">
            <InputTextForm v-model="product.unit_of_measure" label="Unidad de medida" fluid class="flex-1"/>
            <InputTextForm v-model="product.brand" label="Marca" fluid class="flex-1"/>
        </div>
        <TextAreaForm v-model="product.description" label="Descripción" />
        <TextAreaForm v-model="product.notes" label="Notas" />
        <div class="flex gap-4" v-if="!isEdit">
            <FileUploadForm v-model="product.file" label="Subir archivo"/>
        </div>
        <div class="flex flex-col" v-if="isEdit">
            <div class="mb-4 flex items-center gap-4">
                <div class="svg-medium">
                    <img src="/assets/document.svg" alt="">
                </div>
                <span>{{ product.url_data }}</span>
            </div>
            <div class="flex">
                <FileUploadForm v-model="product.file" label="Reemplazar archivo"/>
            </div>
        </div>
    </div>

</template>