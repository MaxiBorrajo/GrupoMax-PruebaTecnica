<template>
  <section class="flex justify-center items-center bg-slate-200 min-h-screen">
    <div
      class="sm:w-1/2 p-8 shadow-lg bg-cyan-500 flex flex-col justify-center min-h-screen sm:min-h-fit sm:rounded-md"
    >
      <h1 class="text-4xl text-slate-800 mb-7 font-semibold">
        Forgot password
      </h1>
      <h3 class="text-md text-slate-800 mb-7 font-normal">
        Enter your email address to sent you a password recovery email
      </h3>
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
        @submit.prevent="forgotPassword(forgotPasswordForm)"
        class="flex flex-col justify-center gap-y-2"
      >
        <FormInputComponent
          v-model="forgotPasswordForm.email"
          input-label="Email"
          :input-rules="[rules.required]"
          input-type="email"
        />

        <SubmitButtonComponent button-label="Sign in" />
      </v-form>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useUserStore } from "@/stores/UserStore";
import router from "../router/index";
import SubmitButtonComponent from "@/components/SubmitButtonComponent.vue";
import FormInputComponent from "@/components/FormInputComponent.vue";
import ErrorComponent from "@/components/ErrorComponent.vue";
import SuccessComponent from "@/components/SuccessComponent.vue";
import rules from "@/utils/rules";
const form = ref(null);

const showError = ref(false);
const errorMessage = ref(null);
const showSuccess = ref(false);
const successMessage = ref(null);

const forgotPasswordForm = ref({
  email: null,
});

const userStore = useUserStore();

async function forgotPassword(dataForm) {
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await userStore.forgotPassword(dataForm);

      showSuccess.value = true;
      successMessage.value = result.message;
    } catch (err) {
      console.log(err);
      showError.value = true;
      errorMessage.value = err.response.data.error;
    }
  }
}
</script>

<style scoped></style>
