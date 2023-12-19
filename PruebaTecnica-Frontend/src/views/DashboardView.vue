<template>
  <section class="bg-slate-200 min-h-screen">
    <span
      class="absolute text-cyan-500 text-2xl top-5 left-4 cursor-pointer lg:hidden z-10"
      @click="show"
    >
      <i class="fa-solid fa-bars p-1.5 bg-slate-200 rounded-md"></i>
    </span>
    <div
      class="fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-cyan-700 hidden lg:block z-10"
      ref="sidebar"
    >
      <div class="text-slate-200 text-xl flex flex-col h-full relative">
        <FirstSidemenuSelector
          :label="user.first_name +' ' + user.last_name"
          :close-action="close"
          :profile-action="
            () => {
              router.push({ name: 'profile' });
            }
          "
        />
        <hr class="my-2" />
        <SidemenuSelector
          icon="fa-solid fa-list"
          label="My clients"
          @click="selected = 'clients'"
          :selected="selected === 'clients'"
        />
        <SidemenuSelector
          icon="fa-solid fa-user"
          label="Users"
          @click="selected = 'users'"
          :selected="selected === 'users'"
        />
        <SidemenuSelector
          icon="fa-solid fa-right-from-bracket"
          :important="false"
          class="absolute bottom-0 w-full"
          label="Log out"
          @click="logout"
        />
      </div>
    </div>
    <div
      class="z-0 absolute top-0 right-0 bg-slate-200 w-full lg:w-[calc(100vw-300px)] min-h-screen flex items-center justify-center lg:pl-10 lg:p-5"
    >
      <ClientsView v-if="selected === 'clients'" />
      <UsersView v-if="selected === 'users'" />
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import VueCookies from "vue-cookies";
import SidemenuSelector from "@/components/SidemenuSelector.vue";
import FirstSidemenuSelector from "@/components/FirstSidemenuSelector.vue";
import { useUserStore } from "@/stores/UserStore";
import UsersView from "./UsersView.vue";
import ClientsView from "./ClientsView.vue";
import router from "@/router";

const user = ref(VueCookies.get("user"));
const sidebar = ref(null);
const selected = ref("clients");
const userStore = useUserStore();

function show() {
  sidebar.value.style = "display:block";
}

function close() {
  sidebar.value.style = "display:hidden";
}

async function logout() {
  try {
    const result = await userStore.logout();

    if (result) {
      VueCookies.remove("token");
      VueCookies.remove("user");
      router.push({ name: "login" });
    }
  } catch (err) {
    alert(err.response.data.error);
  }
}
</script>

<style scoped></style>
