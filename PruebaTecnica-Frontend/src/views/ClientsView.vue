<template>
  <div
    class="min-h-screen w-full bg-cyan-500 lg:rounded-md text-slate-50 px-5 py-20 lg:py-10"
  >
    <span class="w-full flex flex-col gap-y-5 lg:flex-row lg:justify-between"
      ><h1 class="text-4xl font-bold">My clients</h1>
      <SearchBarComponent v-model="search" />
    </span>
    <v-data-table-server
      class="rounded-md"
      v-if="data"
      :items-per-page="+data.per_page"
      :headers="headers"
      :items-length="+data.total"
      :items="data.data"
      :loading="loading"
      :search="search"
      @update:options="loadItems"
    >
      <template v-slot:item.actions="{ item }">
        <span class="flex justify-around w-full"
          ><i class="fa-solid fa-pen cursor-pointer hover:text-cyan-500"></i> <i class="fa-solid fa-trash-can cursor-pointer hover:text-cyan-500"></i
        ></span>
      </template>
      <template v-slot:no-data>
        <h1>No clients found</h1>
      </template>
    </v-data-table-server>
  </div>
</template>

<script setup>
import { onBeforeMount, ref, watch } from "vue";
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
  { title: "Actions", key: "actions", sortable: false },
]);
const data = ref(null);
const loading = ref(false);
const search = ref(null);

async function getClients(page = 1, sortBy = "", orderBy = "", filters = null, limit=20) {
  loading.value = true;
  const result = await clientStore.getClients(sortBy, orderBy, page, filters,limit);

  data.value = result.resource;
  loading.value = false;
}

async function loadItems({ page, sortBy, search, itemsPerPage }) {
  const sort = sortBy.length > 0 ? sortBy[0].key : "";
  const order = sortBy.length > 0 ? sortBy[0].order : "";
  const filters = [];

  if (search) {
    filters.push({ filter: "keyword", value: search });
  }

  itemsPerPage = itemsPerPage === -1 ? data.value.total : itemsPerPage;

  await getClients(page, sort, order, filters, itemsPerPage);
}

onBeforeMount(async () => {
  await getClients();
});
</script>

<style scoped></style>
