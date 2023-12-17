<template>
    <v-btn
      v-ripple
      type="submit"
      class="bg-slate-100 text-slate-800 w-fit"
      :append-icon="buttonAppendIcon"
      :prepend-icon="buttonPrependIcon"
      :disabled="buttonDisabled"
      >{{ buttonLabel }}</v-btn
    >
  </template>
  
  <script setup>
  
  const props = defineProps({
    buttonLabel: String,
    buttonAppendIcon: String,
    buttonPrependIcon: String,
    buttonDisabled: Boolean
  });
  </script>
  
  <style scoped lang="scss">
  </style>