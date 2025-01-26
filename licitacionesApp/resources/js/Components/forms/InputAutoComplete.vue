<script setup>
    import { AutoComplete, FloatLabel } from 'primevue';
    import { RequestService } from '@/Composables/RequestService';
import { ref } from 'vue';

    const props = defineProps({
        route: {
            type: String,
            required: true
        },
        modelValue: {
            type: null,
            required: true
        },
        label: {
            type: String,
        }
    })
    const emit = defineEmits(['update:modelValue']);
    const {request} = RequestService();

    const list = ref([]);
    const suggestions = ref([]);
    const optionSelected = ref(props.modelValue);

    function getList(){
        request(`${props.route}`).then(response => {
            list.value = response.data.supplier;
        })
    }
    getList();

    function search(event){
        const query = event.query
        suggestions.value = list.value.filter(suggestion => {
            return suggestion.name.toLowerCase().includes(query.toLowerCase());
        });
        
    }

    function updateModelValue(){
        emit('update:modelValue', optionSelected.value.id);
    }

</script>
<template>
    <div class="">
        <FloatLabel variant="in">
            <AutoComplete
                v-model="optionSelected" 
                fluid 
                class="flex-1"
                @complete="search"
                optionLabel="name"
                :suggestions="suggestions"
                dropdown
                @option-select="updateModelValue"
            />
            <label :for="label + '-id'">{{ label }}</label>
        </FloatLabel>
    </div>
</template>