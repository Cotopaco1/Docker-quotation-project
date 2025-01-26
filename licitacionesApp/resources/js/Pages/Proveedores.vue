<script setup>    
    import LayoutPrincipal from '@/Layouts/Principal.vue';
    import SupplierCreate from '@/Components/suppliers/SupplierCreate.vue';
    import SearchBar from '@/Components/SearchBar.vue';
    import PlusButton from '@/Components/buttons/PlusButton.vue';
    import EyeButton from '@/Components/buttons/EyeButton.vue';
    import SupplierView from '@/Components/suppliers/SupplierView.vue';
    import { RequestService } from '@/Composables/RequestService';
    import { DataTable, Column } from 'primevue';
    import { ref } from 'vue';
    const props = defineProps({
        currentRoute: {
            type: String,
            required: true
        },
        suppliers: {
            type: Array,
            required: true
        }
    })
    const {request} = RequestService();
    const showCreateModal = ref(false);
    const showViewModal = ref(false);
    const supplierToView = ref({});
    const localSuppliers = ref(props.suppliers);

    function viewSupplier(supplier){
        supplierToView.value = JSON.parse(JSON.stringify(supplier));
        showViewModal.value = true;
    }
    function getSuppliers(){
        request('/supplier').then(response => {
            localSuppliers.value = response.suppliers;
        });
    }
</script>
<template>
    <SupplierCreate 
        :showModal="showCreateModal" 
        @close="showCreateModal = false"
        @updated="getSuppliers"
    />
    <SupplierView 
        :showModal="showViewModal" @updated="getSuppliers"
        @close="showViewModal = false" v-model="supplierToView"/>
    <LayoutPrincipal :currentRoute="currentRoute">
        <div class="flex gap-10 justify-end">
            <!-- <div class="flex-1">
                <SearchBar />
            </div> -->
            <PlusButton class="pt-5" @click="showCreateModal = true" />
        </div>
        <div class="mt-6">
            <DataTable :value="localSuppliers" size="small" stripedRows paginator :rows="15">
                <Column field="id" header="ID"></Column>
                <Column field="name" header="Nombre"></Column>
                <Column field="identification" header="NIT"></Column>
                <Column field="phone" header="Telefono"></Column>
                <Column field="address" header="Dirección"></Column>
                <Column field="city" header="Ciudad"></Column>
                <Column field="website" header="Website"></Column>
                <Column header="Acciones"> 
                    <template #body="slotProps">
                        <div class="flex justify-end">
                            <EyeButton @click="viewSupplier(slotProps.data)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </LayoutPrincipal>
</template>