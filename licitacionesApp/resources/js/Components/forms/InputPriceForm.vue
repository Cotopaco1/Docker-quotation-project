<script setup>
    import { InputNumber, FloatLabel } from 'primevue';
import { ref, watch } from 'vue';
    const props = defineProps({
        label: String,
        fluid: {
            type: Boolean,
            default: false
        },
        modelValue: {
            type: [Number, String],
            default: ''
        }
    })
    const localValue = ref(props.modelValue);
    const emit = defineEmits(['update:modelValue']);
    watch( localValue, (newValue) => {
        emit('update:modelValue', newValue);
    })

</script>
<template>
    <div>
        <FloatLabel variant="in" >
            <InputNumber 
                v-model="localValue" 
                :id="label + '-id'" 
                fluid 
                :minFractionDigits="2"
                locale="es-CO"
            />
            <label :for="label + '-id'">{{ label }}</label>
        </FloatLabel>
    </div>
</template>