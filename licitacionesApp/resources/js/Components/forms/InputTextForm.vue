<script setup>
    import { InputText, FloatLabel } from 'primevue';
import { ref, watch } from 'vue';
    const props = defineProps({
        label: String,
        fluid: {
            type: Boolean,
            default: false
        },
        modelValue: {
            type: String,
            default: ''
        }
    })
    
    const localValue = ref(props.modelValue);
    const emit = defineEmits(['update:modelValue']);

    watch(localValue, (newValue) => {
        emit('update:modelValue', newValue);
    }, { deep: true });

</script>
<template>
    <div>
        <FloatLabel variant="in" >
            <InputText :id="label + '-id'" fluid v-model="localValue" />
            <label :for="label + '-id'">{{ label }}</label>
        </FloatLabel>
    </div>
</template>