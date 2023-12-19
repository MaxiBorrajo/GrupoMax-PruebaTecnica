<template>
  <div
    class="min-h-screen w-full bg-cyan-500 lg:rounded-md text-slate-50 px-5 py-20 lg:py-10"
  >
    <span class="w-full flex flex-col gap-y-5 lg:flex-row lg:justify-between"
      ><h1 class="text-4xl font-bold">Users</h1>
      <SearchBarComponent v-model="search" />
    </span>
    <ErrorComponent
      v-if="showError"
      :error-message="errorMessage"
      class="mb-7"
    />
    <v-data-table-server
      class="rounded-md text-sm"
      v-if="data"
      :items-per-page="+data.per_page"
      :headers="headers"
      :items-length="+data.total"
      :items="data.data"
      :loading="loading"
      :search="search"
      @update:options="loadItems"
    >
      <template v-slot:no-data>
        <h1>No users found</h1>
      </template>
    </v-data-table-server>
  </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import SearchBarComponent from "@/components/SearchBarComponent.vue";
import { useUserStore } from "@/stores/UserStore";
import ErrorComponent from "@/components/ErrorComponent.vue";
const userStore = useUserStore();

const showError = ref(false);
const errorMessage = ref(null);
const headers = ref([
  {
    title: "First name",
    key: "first_name",
  },
  {
    title: "Last name",
    key: "last_name",
  },
  { title: "Email", key: "email" },
]);
const data = ref(null);
const loading = ref(false);
const search = ref(null);

async function getUsers(
  page = 1,
  sortBy = "",
  orderBy = "",
  filters = null,
  limit = 20
) {
  try {
    showError.value = false;
    loading.value = true;
    const result = await userStore.getUsers(
      sortBy,
      orderBy,
      page,
      filters,
      limit
    );

    data.value = result.resource;
    loading.value = false;
  } catch (err) {
    loading.value = false;
    console.log(err);
    showError.value = true;
    errorMessage.value = err.response.data.error;
  }
}

async function loadItems({ page, sortBy, search, itemsPerPage }) {
  const sort = sortBy.length > 0 ? sortBy[0].key : "";
  const order = sortBy.length > 0 ? sortBy[0].order : "";
  const filters = [];

  if (search) {
    filters.push({ filter: "keyword", value: search });
  }

  itemsPerPage = itemsPerPage === -1 ? data.value.total : itemsPerPage;

  await getUsers(page, sort, order, filters, itemsPerPage);
}

onBeforeMount(async () => {
  await getUsers();
});
</script>

<style scoped></style>
