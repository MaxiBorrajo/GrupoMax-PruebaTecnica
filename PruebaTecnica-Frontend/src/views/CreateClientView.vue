<template>
  <section
    class="flex justify-center items-center min-h-screen bg-slate-200 sm:py-10"
  >
  <BackButtonComponent />
    <div
      class="w-96 lg:p-8 px-8 py-20 shadow-lg bg-cyan-500 flex flex-col justify-center min-h-screen sm:min-h-fit sm:rounded-md"
    >
      <h1 class="text-4xl text-slate-200 mb-7 font-semibold">Add new client</h1>
      <ErrorComponent
        v-if="showError"
        :error-message="errorMessage"
        class="mb-7"
      />
      <v-form
        ref="form"
        @submit.prevent="createClient(clientForm)"
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
        <SubmitButtonComponent button-label="Create" />
      </v-form>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useClientStore } from "@/stores/ClientStore";
import router from "../router/index";
import SubmitButtonComponent from "@/components/SubmitButtonComponent.vue";
import FormInputComponent from "@/components/FormInputComponent.vue";
import ErrorComponent from "@/components/ErrorComponent.vue";
import rules from "@/utils/rules";
import BackButtonComponent from "@/components/BackButtonComponent.vue";

const form = ref(null);

const showError = ref(false);
const errorMessage = ref(null);

const clientForm = ref({
  first_name: null,
  last_name: null,
  email: null,
  age: null,
  phone_number: null,
  status: "ACTIVE",
});

const clientStore = useClientStore();

async function createClient(dataForm) {
  showError.value = false;
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await clientStore.createClient(dataForm);

      if (result) {
        router.push({ name: "dashboard" });
      }
    } catch (err) {
      console.log(err);
      showError.value = true;
      errorMessage.value = err.response.data.error;
    }
  }
}
</script>

<style scoped></style>
