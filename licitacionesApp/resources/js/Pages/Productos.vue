<script setup>
    import LayoutPrincipal from '@/Layouts/Principal.vue';
    import { ref, watch } from 'vue';
    import SearchBar from '@/Components/SearchBar.vue';
    import PlusButton from '@/Components/buttons/PlusButton.vue';
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import EyeButton from '@/Components/buttons/EyeButton.vue';
    import DownloadDocumentButton from '@/Components/buttons/DownloadDocumentButton.vue';
    import ProductCreate from '@/Components/products/ProductCreate.vue';
    import ProductView from '@/Components/products/ProductView.vue';
    import { RequestService } from '@/Composables/RequestService';
    const {request} = RequestService();

    const props = defineProps({
        currentRoute: {
            type: String,
            required: true
        },
        products: Array,
    });

    const filterProducts = ref(props.products);

    const showProductCreate = ref(false);
    const showProductView = ref(false);
    const productToView = ref({});

    function viewProduct(product) {
        productToView.value = JSON.parse(JSON.stringify(product));
        console.log(productToView.value);
        showProductView.value = true;
        console.log(productToView.value);
    }
    function getProducts(){
        request('/product').then(response => {
            console.log(response);
            filterProducts.value = response.products;
        });
    }
   
</script>
<template>
    
    <ProductCreate 
        :showModal="showProductCreate" 
        @close="showProductCreate = false"
        @updated="getProducts"
    />
    
    <ProductView 
        v-model="productToView" 
        :showModal="showProductView" 
        @close="showProductView = false"
        @updated="getProducts"
    />

    <LayoutPrincipal :currentRoute="currentRoute">
        <div class="flex gap-10 mb-10">
            <SearchBar v-model="filterProducts" route="/search" class="flex-1" @clear="filterProducts = props.products"/>
            <PlusButton @click="showProductCreate = true" class="pt-6"/>
        </div>
        <div >
            <DataTable :value="filterProducts" size="small" stripedRows paginator :rows="10">
                <Column field="id" header="ID"></Column>
                <Column field="name" header="Nombre"></Column>
                <Column field="supplier" header="Proveedor"></Column>
                <Column field="unit_of_measure" header="Unidad de medida"></Column>
                <Column field="description" header="Descripción" class="truncate-text"></Column>
                <Column field="unit_price_withouth_tax" header="Precio unitario sin impuestos"></Column>
                <Column field="brand" header="Marca"></Column>
                <Column field="notes" header="Notas" class="truncate-text"></Column>
                <Column header="Acciones"> 
                    <template #body="slotProps">
                        <div class="flex justify-end">
                            <DownloadDocumentButton v-if="slotProps.data.url_data" :route="'/files/product/'+ slotProps.data.id"/>
                            <EyeButton @click="viewProduct(slotProps.data)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </LayoutPrincipal>
</template>