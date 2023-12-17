<template>
  <div class="w-fit p-3 bg-red-500 text-md text-slate-100 rounded-md">
    {{errorMessage}}
  </div>
</template>

<script setup>
const props = defineProps({
  errorMessage: String,
});
</script>

<style scoped></style>
