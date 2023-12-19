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
        <span class="w-fit flex flex-col gap-y-5">
          <SubmitButtonComponent
            button-label="Update"
            :button-loading="loading"
          />
          <v-btn
            @click="openDialog"
            class="bg-red-500 text-slate-200 hover:bg-red-700 w-fit"
            >Delete account</v-btn
          >
        </span>
      </v-form>
    </div>
    <DeleteDialogComponent
      v-model="showDialog"
      :close-delete="closeDialog"
      :delete-action="deleteUser"
      label="Are you sure you want to delete your account? All information will be lost"
    />
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
import VueCookies from "vue-cookies";
import router from "@/router";
import DeleteDialogComponent from "@/components/DeleteDialogComponent.vue";

const form = ref(null);
const showError = ref(false);
const errorMessage = ref(null);
const showDialog = ref(false);
const userForm = ref({
  first_name: null,
  last_name: null,
  email: null,
});
const loading = ref(false);
const showSuccess = ref(false);
const successMessage = ref(null);

const userStore = useUserStore();

async function updateUser(dataForm) {
  loading.value = true;
  showError.value = false;
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await userStore.updateUser(dataForm);

      if (result) {
        VueCookies.remove("user");
        VueCookies.set("user", result.resource);
        loading.value = false;
        showSuccess.value = true;
        successMessage.value = result.message;
      }
    } catch (err) {
      loading.value = false;
      console.log(err);
      showError.value = true;
      errorMessage.value = err.response;
    }
  }
}

async function getUser() {
  showError.value = false;
  try {
    const result = await userStore.getCurrentUser();

    userForm.value.first_name = result.resource.first_name;
    userForm.value.last_name = result.resource.last_name;
    userForm.value.email = result.resource.email;
  } catch (err) {
    console.log(err);
    showError.value = true;
    errorMessage.value = err.response;
  }
}

async function deleteUser() {
  try {
    showError.value = false;
    const result = await userStore.deleteUser();

    if (result) {
      closeDialog();
      VueCookies.remove("token");
      VueCookies.remove("user");
      router.push({ name: "login" });
    }
  } catch (err) {
    console.log(err);
    showError.value = true;
    errorMessage.value = err.response;
  }
}

function openDialog() {
  showDialog.value = true;
}

function closeDialog() {
  showDialog.value = false;
}

onBeforeMount(async () => {
  await getUser();
});
</script>

<style scoped></style>
