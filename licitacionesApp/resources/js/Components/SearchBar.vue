<script setup>
    import { AutoComplete } from 'primevue';
    import { ref, computed } from 'vue';
    import axios from 'axios';
    import { RequestService } from '@/Composables/RequestService';

    const { request } = RequestService();
    
    const props = defineProps({
        route: {
            type: String,
            required: true
        },
        modelValue: {
            type: Array,
            required: false
        },
        withSuggestions:{
            type: Boolean,
            default: false
        }
    })
    const emit = defineEmits(['selected', 'update:modelValue', 'clear']);
    const results = ref([]);   
    const suggestions = ref([]);

    function getResults(query){
        request(`${props.route}?query=${query}`).then(response => {
            results.value = response.searchResults;
            suggestions.value = results.value.map(result => {
                return result.searchable;
            });
            emit('update:modelValue', suggestions.value);
        }) 
    }

    function search(event){
        const query = event.query
        getResults(query);
    }

    const computedSuggestions = computed(() => {
        return props.withSuggestions ? suggestions.value : [];
    });

</script>
<template>
    <div>
        <p for="searchBar" class="block">Barra de busqueda</p>
        <div class="flex">
            <AutoComplete 
                inpitId="searchBar"
                fluid 
                class="flex-1"
                @complete="search"
                optionLabel="name"
                @clear="emit('clear')"
                :suggestions="computedSuggestions"
                @option-select="emit('selected', $event.value)"
            />
            <div class="svg-medium">
                <img src="/assets/lens.svg" alt="">
            </div>
        </div>
    </div>
</template>