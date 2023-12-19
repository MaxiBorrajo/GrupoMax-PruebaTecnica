<template>
  <section
    class="flex justify-center items-center min-h-screen bg-slate-200 sm:py-10"
  >
  <BackButtonComponent />
    <div
      class="w-96 px-8 py-20 lg:p-8 shadow-lg bg-cyan-500 flex flex-col justify-center min-h-screen sm:min-h-fit sm:rounded-md"
    >
      <h1 class="text-4xl text-slate-200 mb-7 font-semibold">Edit client</h1>
      <ErrorComponent
        v-if="showError"
        :error="error"
        class="mb-7"
      />
      <SuccessComponent
        v-if="showSuccess"
        :success-message="successMessage"
        class="mb-7"
      />
      <v-form
        ref="form"
        @submit.prevent="updateClient(clientForm)"
        class="flex flex-col justify-center gap-y-2"
      >
        <FormInputComponent
          v-model="clientForm.first_name"
          input-label="First name"
          :input-rules="[rules.required]"
          input-type="text"
        />
        <FormInputComponent
          v-model="clientForm.last_name"
          input-label="Last name"
          :input-rules="[rules.required]"
          input-type="text"
        />
        <FormInputComponent
          v-model="clientForm.email"
          input-label="Email"
          :input-rules="[rules.required, rules.email]"
          input-type="email"
        />
        <FormInputComponent
          v-model="clientForm.age"
          input-label="Age"
          :input-rules="[
            rules.required,
            rules.maximumValue(99),
            rules.minimumValue(1),
          ]"
          input-type="number"
        />
        <FormInputComponent
          v-model="clientForm.phone_number"
          input-label="Phone number"
          :input-rules="[rules.required]"
          input-type="tel"
        />
        <v-radio-group v-model="clientForm.status" inline>
          <v-radio
            label="Active"
            value="ACTIVE"
            color="white"
            class="text-slate-50"
          ></v-radio>
          <v-spacer></v-spacer>
          <v-radio
            label="Inactive"
            value="INACTIVE"
            color="white"
            class="text-slate-50"
          ></v-radio>
        </v-radio-group>
        <SubmitButtonComponent button-label="Update" :button-loading="loading" />
      </v-form>
    </div>
  </section>
</template>

<script setup>
import { ref, onBeforeMount } from "vue";
import { useClientStore } from "@/stores/ClientStore";
import SubmitButtonComponent from "@/components/SubmitButtonComponent.vue";
import FormInputComponent from "@/components/FormInputComponent.vue";
import ErrorComponent from "@/components/ErrorComponent.vue";
import SuccessComponent from "@/components/SuccessComponent.vue";
import rules from "@/utils/rules";
import { useRoute } from "vue-router";
import BackButtonComponent from "@/components/BackButtonComponent.vue";

const form = ref(null);
const route = useRoute();
const showError = ref(false);
const error = ref(null);
const loading = ref(false);
const clientForm = ref({
  first_name: null,
  last_name: null,
  email: null,
  age: null,
  phone_number: null,
  status: "ACTIVE",
});

const showSuccess = ref(false);
const successMessage = ref(null);

const clientStore = useClientStore();

async function updateClient(dataForm) {
  loading.value = true;
  showError.value = false;
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await clientStore.updateClient(route.params.id, dataForm);

      if (result) {
        loading.value = false;
        showSuccess.value = true;
        successMessage.value = result.message;
      }
    } catch (err) {
      loading.value = false;
      console.log(err);
      showError.value = true;
      error.value = err.response;
    }
  }
}

async function getClient() {
  showError.value = false;
  try {
    const result = await clientStore.getClient(route.params.id);

    clientForm.value.first_name = result.resource.first_name;
    clientForm.value.last_name = result.resource.last_name;
    clientForm.value.email = result.resource.email;
    clientForm.value.age = result.resource.age;
    clientForm.value.phone_number = result.resource.phone_number;
    clientForm.value.status = result.resource.status;
  } catch (err) {
    console.log(err);
    showError.value = true;
    error.value = err.response;
  }
}

onBeforeMount(async () => {
  await getClient();
});
</script>

<style scoped></style>
