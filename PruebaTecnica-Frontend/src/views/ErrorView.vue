<template>
  <section class="flex flex-col justify-center items-center bg-slate-200 min-h-screen gap-y-10">
    <h1 class="text-9xl text-cyan-500">404</h1>
    <h3 class="text-lg text-cyan-500">This page doesn't exist</h3>
    <v-btn
      @click="router.push({ name: 'login' })"
      class="bg-cyan-500 text-slate-200"
      >Go to login</v-btn
    >
  </section>
</template>

<script setup>
import router from "../router/index";
</script>

<style scoped></style>
