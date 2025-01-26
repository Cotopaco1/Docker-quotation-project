<script setup>
    import { ref, watch } from 'vue';
    import { InputNumber, FloatLabel } from 'primevue';

    const props = defineProps({
        label: {
            type: String,
            required: true
        },
        modelValue: {
            type: Number,
            required: true
        }
    });
    const emit = defineEmits(['update:modelValue']);
    const inputValue = ref(props.modelValue);
    watch( inputValue, (value) => {
        emit('update:modelValue', value);
    });

</script>
<template>
    <div>
        <FloatLabel variant="in">
            <InputNumber 
            v-model="inputValue" 
            :id="label+'-id'" 
            mode="decimal" 
            :maxFractionDigits="2" 
            suffix="%"
            locale="es-CO"
            />
            <label :for="label+'-id'">{{ label }}</label>
        </FloatLabel>
    </div>
</template>