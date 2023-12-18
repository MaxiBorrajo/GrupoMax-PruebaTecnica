<template>
  <i class="absolute top-5 left-5 fa-solid fa-circle-left cursor-pointer text-slate-50 hover:text-slate-400 lg:text-cyan-500 lg:hover:text-cyan-700 text-2xl" @click="router.go(-1)"></i>
</template>

<script setup>
import router from "@/router";
</script>

<style scoped></style>
