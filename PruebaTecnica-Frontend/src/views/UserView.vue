<template>
  <section
    class="flex justify-center items-center min-h-screen bg-slate-200 sm:py-10"
  >
  <BackButtonComponent />
    <div
      class="w-96 p-8 shadow-lg bg-cyan-500 flex flex-col justify-center min-h-screen sm:min-h-fit sm:rounded-md"
    >
      <h1 class="text-4xl text-slate-200 mb-7 font-semibold">Edit profile</h1>
      <ErrorComponent
        v-if="showError"
        :error-message="errorMessage"
        class="mb-7"
      />
      <SuccessComponent
        v-if="showSuccess"
        :success-message="successMessage"
        class="mb-7"
      />
      <v-form
        ref="form"
        @submit.prevent="updateUser(userForm)"
        class="flex flex-col justify-center gap-y-2"
      >
        <FormInputComponent
          v-model="userForm.first_name"
          input-label="First name"
          :input-rules="[rules.required]"
          input-type="text"
        />
        <FormInputComponent
          v-model="userForm.last_name"
          input-label="Last name"
          :input-rules="[rules.required]"
          input-type="text"
        />
        <FormInputComponent
          v-model="userForm.email"
          input-label="Email"
          :input-rules="[rules.required, rules.email]"
          input-type="email"
        />
        <SubmitButtonComponent button-label="Update" />
      </v-form>
    </div>
  </section>
</template>

<script setup>
import { ref, onBeforeMount } from "vue";
import { useUserStore } from "@/stores/UserStore";
import SubmitButtonComponent from "@/components/SubmitButtonComponent.vue";
import FormInputComponent from "@/components/FormInputComponent.vue";
import ErrorComponent from "@/components/ErrorComponent.vue";
import SuccessComponent from "@/components/SuccessComponent.vue";
import rules from "@/utils/rules";
import BackButtonComponent from "@/components/BackButtonComponent.vue";

const form = ref(null);
const showError = ref(false);
const errorMessage = ref(null);

const userForm = ref({
  first_name: null,
  last_name: null,
  email: null,
});

const showSuccess = ref(false);
const successMessage = ref(null);

const userStore = useUserStore();

async function updateUser(dataForm) {
  showError.value = false;
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await userStore.updateUser(dataForm);

      if (result) {
        showSuccess.value = true;
        successMessage.value = result.message;
      }
    } catch (err) {
      console.log(err);
      showError.value = true;
      errorMessage.value = err.response.data.error;
    }
  }
}

async function getUser() {
  showError.value = false;
  try {
    const result = await userStore.getCurrentUser();

    userForm.value.first_name = result.resource.fullname.split(" ")[0];
    userForm.value.last_name = result.resource.fullname.split(" ")[1];
    userForm.value.email = result.resource.email;
  } catch (err) {
    console.log(err);
    showError.value = true;
    errorMessage.value = err.response.data.error;
  }
}

onBeforeMount(async () => {
  await getUser();
});
</script>

<style scoped></style>
