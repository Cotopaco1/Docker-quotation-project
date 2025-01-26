<script setup>
   defineProps({
         label: String,
   })
</script>
<template> 
    <button type="button" class="button bg-red-500  text-white ">{{ label ?? 'Cancelar' }}</button>
</template>