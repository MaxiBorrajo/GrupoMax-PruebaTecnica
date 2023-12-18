<template>
  <section class="bg-slate-200 min-h-screen">
    <span
      class="absolute text-slate-200 text-2xl top-5 left-4 cursor-pointer lg:hidden"
      @click="show"
    >
      <i class="fa-solid fa-bars p-1.5 bg-cyan-500 rounded-md"></i>
    </span>
    <div
      class="fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-cyan-500 hidden lg:block"
      ref="sidebar"
    >
      <div class="text-slate-200 text-xl flex flex-col h-full relative">
        <FirstSidemenuSelector :label="user.fullname" :close-action="close"/>
        <hr class="my-2" />
        <SidemenuSelector icon="fa-solid fa-list" label="My clients" />
        <SidemenuSelector icon="fa-solid fa-user" label="Users" />
        <SidemenuSelector
          icon="fa-solid fa-right-from-bracket"
          :important="false"
          class="absolute bottom-0 w-full"
          label="Log out"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import VueCookies from "vue-cookies";
import SidemenuSelector from "@/components/SidemenuSelector.vue";
import FirstSidemenuSelector from "@/components/FirstSidemenuSelector.vue";
const user = ref(VueCookies.get("user"));
const sidebar = ref(null);

function show() {
  sidebar.value.style = "display:block";
}

function close() {
  sidebar.value.style = "display:hidden";
}
</script>

<style scoped></style>
