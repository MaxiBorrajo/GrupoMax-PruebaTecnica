<template>
  <section class="flex justify-center items-center bg-slate-200 min-h-screen">
    <div
      class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-cyan-500"
    >
      <div class="text-slate-200 text-xl">
        <SidemenuSelector icon="fa-solid fa-circle-user" :label="user.fullname" :important="true"/>
        <hr class="my-2">
        <SidemenuSelector icon="fa-solid fa-list" label="My clients" :important="false"/>
        <SidemenuSelector icon="fa-solid fa-user" label="Users" :important="false"/>
      </div>
      
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import VueCookies from "vue-cookies";
import SidemenuSelector from "@/components/SidemenuSelector.vue";
const user = ref(VueCookies.get("user"));
</script>

<style scoped></style>
