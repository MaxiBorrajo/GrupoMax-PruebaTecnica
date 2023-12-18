<template>
  <div
    class="h-full w-full bg-cyan-500 lg:rounded-md text-slate-50 px-5 py-20 lg:py-10"
  >
    <span class="w-full flex flex-col gap-y-5 lg:flex-row lg:justify-between"
      ><h1 class="text-4xl font-bold">My clients</h1>
      <SearchBarComponent />
    </span>
    <v-data-table-server
      class="rounded-md"
      v-if="data"
      items-per-page="20"
      :headers="headers"
      :items-length="+data.total"
      :items="data.data"
      :loading="loading"
      @update:options="loadItems"
    ></v-data-table-server>
  </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import SearchBarComponent from "@/components/SearchBarComponent.vue";
import { useClientStore } from "@/stores/ClientStore";

const clientStore = useClientStore();
const headers = ref([
  {
    title: "First name",
    key: "first_name",
  },
  {
    title: "Last name",
    key: "last_name",
  },
  { title: "Age", key: "age" },
  { title: "Email", key: "email" },
  { title: "Phone number", key: "phone_number" },
  { title: "Status", key: "status" },
]);
const data = ref(null);
const loading = ref(false);

async function getClients(page = 1, sortBy = "", orderBy = "") {
  loading.value = true;
  const result = await clientStore.getClients(sortBy, orderBy, page);

  data.value = result.resource;
  loading.value = false;
}

async function loadItems({ page, sortBy }) {
  if (sortBy[0]) {
    await getClients(page, sortBy[0].key, sortBy[0].order);
  } else {
    await getClients(page);
  }
}

onBeforeMount(async () => {
  await getClients();
});
</script>

<style scoped></style>
