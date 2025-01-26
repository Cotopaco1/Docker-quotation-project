<script setup>
    import { FileUpload } from 'primevue';
    import { ref, watch } from 'vue';
    const props = defineProps({
        label: String,
        fluid: {
            type: Boolean,
            default: false
        },
        modelValue: {
            type: [File, String],
            default: ''
        }
    })
    const emit = defineEmits(['update:modelValue']);

    function onUpload(event) {
        const file = event.files[0];
        emit('update:modelValue', file);
    }

</script>
<template>
    <div>
        <FileUpload 
            mode="basic" 
            customUpload
            accept="image/*" 
            :maxFileSize="1000000" 
            @select="onUpload"
            :chooseLabel="label"
            fluid
        />
        
    </div>
</template>