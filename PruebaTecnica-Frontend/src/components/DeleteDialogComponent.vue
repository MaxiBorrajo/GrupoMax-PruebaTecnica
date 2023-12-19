<template>
  <v-dialog max-width="500px">
    <v-card>
      <v-card-title class="text-sm text-wrap"
        >{{ label }}</v-card-title
      >
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="closeDelete" class="bg-cyan-500 text-slate-200"
          >Cancel</v-btn
        >
        <v-btn @click="deleteAction" class="bg-cyan-500 text-slate-200 hover:bg-red-500">OK</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
const props = defineProps({
  closeDelete: Function,
  deleteAction: Function,
  label:String
});
</script>

<style scoped></style>
