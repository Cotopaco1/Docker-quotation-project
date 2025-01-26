<script setup>
    import { Textarea, FloatLabel } from 'primevue';
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
    const emit = defineEmits(['update:modelValue'])

    const localValue = ref(props.modelValue);

    watch( localValue, (newValue) => {
        emit('update:modelValue', newValue);
    });

</script>
<template>
    <div>
        <FloatLabel variant="in" >
            <Textarea v-model="localValue" :id="label + '-id'" autoResize rows="5" fluid  />
            <label :for="label + '-id'">{{ label }}</label>
        </FloatLabel>
    </div>
</template>