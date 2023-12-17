<template>
  <v-text-field
    class="text-slate-800 w-full" 
    :label="inputLabel"
    :required="inputRequired"
    :prepend-icon="inputPrependIcon"
    :prepend-inner-icon="inputPrependInnerIcon"
    :append-icon="inputAppendIcon"
    :append-inner-icon="inputAppendInnerIcon"
    :placeholder="inputPlaceholder"
    :rules="inputRules"
    :type="inputType"
    variant="solo"
  ></v-text-field>
</template>

<script setup>
const props = defineProps({
  inputLabel: String,
  inputPlaceholder: String,
  inputType: String,
  inputRequired: Boolean,
  inputPrependIcon: String,
  inputPrependInnerIcon: String,
  inputAppendIcon: String,
  inputAppendInnerIcon: String,
  inputRules: Array,
});
</script>

<style scoped></style>
