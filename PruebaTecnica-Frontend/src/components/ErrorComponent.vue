<template>
  <div class="w-fit bg-red-300 text-red-700 rounded-md p-3 text-sm">
    <ul v-if="typeof error.data.error != 'string'">
      <li
        v-for="(errors, field) in error.data.error"
        :key="field"
        class="flex gap-x-2"
      >
        <ul>
          <li v-for="(message, index) in errors" :key="index">
            {{ message }}
          </li>
        </ul>
      </li>
    </ul>
    <div v-else>
      {{ error.data.error }}
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  error: Object,
});
</script>

<style scoped></style>
