<template>
  <i class="absolute top-5 left-5 fa-solid fa-circle-left cursor-pointer text-slate-500 hover:text-slate-800 sm:text-cyan-500 sm:hover:text-cyan-700 text-2xl" @click="router.go(-1)"></i>
</template>

<script setup>
import router from "@/router";
</script>

<style scoped></style>
