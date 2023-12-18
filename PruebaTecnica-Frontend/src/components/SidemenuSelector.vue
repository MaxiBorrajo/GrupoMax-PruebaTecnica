<template>
  <div
    class="p-2.5 mt-1 flex items-center hover:bg-slate-200 hover:text-cyan-500 cursor-pointer"
  >
    <i :class="icon"></i>
    <p
      class="text-[15px] ml-3"
      :class="important ? 'font-bold' : 'font-normal'"
    >
      {{ label }}
    </p>
  </div>
</template>

<script setup>
const props = defineProps({
  icon: String,
  label: String,
  important: Boolean,
});
</script>

<style scoped></style>
