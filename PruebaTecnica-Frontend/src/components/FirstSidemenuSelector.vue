<template>
    <div
      class="p-2.5 mt-1 flex items-center justify-between hover:bg-slate-200 hover:text-cyan-500 w-full rounded-md"
    >
    <span class=" flex items-center gap-x-3">
      <i class="fa-solid fa-circle-user"></i>
      <p
        class="text-[15px] font-bold cursor-pointer"
        @click="profileAction"
      >
        {{ label }}
      </p>
    </span>
      <i class="fa-solid fa-xmark cursor-pointer hover:text-slate-200 hover:bg-cyan-500 px-1 py-0.5 rounded-md lg:hidden" @click="closeAction"></i>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    label: String,
    closeAction:Function,
    profileAction:Function
  });

  </script>
  
  <style scoped></style>
  