<template>
  <v-dialog max-width="500px">
    <v-card>
      <v-card-title class="text-sm text-wrap"
        >Are you sure you want to delete this client? All information will be lost</v-card-title
      >
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="closeDelete" class="bg-cyan-500 text-slate-200"
          >Cancel</v-btn
        >
        <v-btn @click="deleteClient" class="bg-cyan-500 text-slate-200 hover:bg-red-500"
          >OK</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
const props = defineProps({
  closeDelete: Function,
  deleteClient: Function,
});
</script>

<style scoped></style>
