<template>
  <div
    class="min-h-screen w-full bg-cyan-500 lg:rounded-md text-slate-50 px-5 py-20 lg:py-10"
  >
    <span class="w-full flex flex-col gap-y-5 lg:flex-row lg:justify-between"
      ><h1 class="text-4xl font-bold">My clients</h1>
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
      <template v-slot:item.actions="{ item }">
        <span class="flex justify-around w-full"
          ><i class="fa-solid fa-pen cursor-pointer hover:text-cyan-500"></i>
          <i
            class="fa-solid fa-trash-can cursor-pointer hover:text-red-500"
            @click="openDialog(item.id)"
          ></i
        ></span>
      </template>
      <template v-slot:no-data>
        <h1>No clients found</h1>
      </template>
    </v-data-table-server>
    <DeleteClientDialogComponent
      v-model="showDialog"
      :closeDelete="closeDialog"
      :delete-client="deleteClient"
    />
  </div>
</template>

<script setup>
import { onBeforeMount, ref, watch } from "vue";
import SearchBarComponent from "@/components/SearchBarComponent.vue";
import { useClientStore } from "@/stores/ClientStore";
import ErrorComponent from "@/components/ErrorComponent.vue";
import DeleteClientDialogComponent from "@/components/DeleteClientDialogComponent.vue";
const clientStore = useClientStore();

const showError = ref(false);
const errorMessage = ref(null);
const clientIdToDelete = ref(null);
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
const sort = ref(null);
const order = ref(null);
const loading = ref(false);
const search = ref(null);
const currentPage = ref(null);
const limit = ref(null);
const showDialog = ref(false);

async function getClients(
  page = 1,
  sortBy = "",
  orderBy = "",
  filters = null,
  limit = 20
) {
  try {
    loading.value = true;
    const result = await clientStore.getClients(
      sortBy,
      orderBy,
      page,
      filters,
      limit
    );

    data.value = result.resource;
    loading.value = false;
  } catch (err) {
    console.log(err);
    showError.value = true;
    errorMessage.value = err.response.data.error;
  }
}

async function deleteClient() {
  try {
    const result = await clientStore.deleteClient(clientIdToDelete.value);

    if (result) {
      const filters = [];

      if (search.value) {
        filters.push({ filter: "keyword", value: search.value });
      }

      await getClients(
        currentPage.value,
        sort.value,
        order.value,
        filters,
        limit.value
      );

      closeDialog();
    }
  } catch (err) {
    console.log(err);
    showError.value = true;
    errorMessage.value = err.response.data.error;
  }
}

function openDialog(idClient) {
  showDialog.value = true;
  clientIdToDelete.value = idClient;
}

function closeDialog() {
  showDialog.value = false;
}

async function loadItems({ page, sortBy, search, itemsPerPage }) {
  sort.value = sortBy.length > 0 ? sortBy[0].key : "";
  order.value = sortBy.length > 0 ? sortBy[0].order : "";
  currentPage.value = page;
  limit.value = itemsPerPage;
  const filters = [];

  if (search) {
    filters.push({ filter: "keyword", value: search });
  }

  itemsPerPage = itemsPerPage === -1 ? data.value.total : itemsPerPage;

  await getClients(page.value, sort.value, order.value, filters, itemsPerPage);
}

onBeforeMount(async () => {
  await getClients();
});
</script>

<style scoped></style>
