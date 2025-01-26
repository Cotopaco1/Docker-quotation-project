<script setup>
    import LayoutPrincipal from '@/Layouts/Principal.vue';
    import SearchBar from '@/Components/SearchBar.vue';
    import { ref } from 'vue';
    import InputNumberPercentage from '@/Components/forms/InputNumberPercentageForm.vue';
    import TrashButton from '@/Components/buttons/TrashButton.vue';
    import GeneralButton from '@/Components/buttons/GeneralButton.vue';
    import { DataTable, Column, InputNumber } from 'primevue';
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import { alerError } from '@/Composables/AlertService';
    const props = defineProps({
        currentRoute: {
            type: String,
            required: true
        }
    })
    const profitPercentage = ref(0);
    const productsSelected = ref([]);

    function addProductSelected(product) {
        const isDuplicate = productsSelected.value.some( element => element.id === product.id);
        if(isDuplicate) return;
        product.quantity = 1;
        productsSelected.value.push(product);
    }
    function deleteProductSelected(product){
        productsSelected.value = productsSelected.value.filter( element => element.id !== product.id);
    }
    function createQuotation(){
        if(productsSelected.value.length === 0){
            alerError("No hay productos seleccionados");
            return;
        }
        axios.post('/quotation/products', {
            profit_percentage: profitPercentage.value,
            items: productsSelected.value
        }, {responseType: 'blob',})
            .then( response => {

                const url = window.URL.createObjectURL(response.data);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'cotizacion-app.zip'); // Nombre del archivo
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link); // Eliminar el enlace temporal
                window.URL.revokeObjectURL(url); // Limpiar la URL temporal
                
            })
            .catch( err => {
                alerError(err?.response?.data?.message ?? "Error al generar la cotización");
            });
        
    }
    
</script>
<template>
    <LayoutPrincipal :currentRoute="currentRoute">
        <div >
            <div class="flex flex-col gap-4 mb-4">
                <InputNumberPercentage 
                    v-model="profitPercentage" 
                    label="Porcentaje de ganancia"
                />
                <div>
                    <SearchBar 
                        route="/search" 
                        @selected="addProductSelected"
                        :withSuggestions="true"
                    />
                </div>
            </div>
            <div>
                <DataTable :value="productsSelected" size="small" stripedRows>
                    <Column field="name" header="Nombre"></Column>
                    <Column field="supplier" header="Proveedor"></Column>
                    <Column field="unit_of_measure" header="Unidad de medida"></Column>
                    <Column field="unit_price_withouth_tax" header="Precio unitario - Sin IVA"></Column>
                    <Column field="brand" header="Marca"></Column>
                    <Column header="Cantidad" >
                        <template #body="slotProps">
                            <InputNumber 
                                v-model="slotProps.data.quantity" 
                                showButtons buttonLayout="vertical" 
                                style="width: 3rem" :min="1" :max="99"
                            />
                        </template>
                    </Column>
                    <Column header="Acciones"> 
                        <template #body="slotProps">
                            <div class="flex justify-end">
                                <TrashButton @click="deleteProductSelected(slotProps.data)" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
            <div class="mt-4">
                <GeneralButton @click="createQuotation" class="bg-primary-6 text-white" label="Generar"/>
            </div>
        </div>
    </LayoutPrincipal>
</template>