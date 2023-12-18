<template>
  <div
    class="p-2.5 mt-1 flex items-center hover:bg-slate-200 hover:text-cyan-500 cursor-pointer rounded-md"
    :class="selected ? 'bg-slate-200 text-cyan-500 ' : ''"
  >
    <i :class="icon"></i>
    <p class="text-[15px] ml-3 font-normal'">
      {{ label }}
    </p>
  </div>
</template>

<script setup>
const props = defineProps({
  icon: String,
  label: String,
  selected: Boolean,
});
</script>

<style scoped></style>
