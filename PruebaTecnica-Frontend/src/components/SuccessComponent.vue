<template>
  <div class="w-fit p-3 bg-green-500 text-md text-slate-100 rounded-md">
    {{ successMessage }}
  </div>
</template>

<script setup>
const props = defineProps({
  successMessage: String,
});
</script>

<style scoped></style>
