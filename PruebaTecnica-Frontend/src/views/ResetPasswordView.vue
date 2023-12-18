<template>
  <section class="flex justify-center items-center bg-slate-200 min-h-screen">
    <div
      class="sm:w-1/2 p-8 shadow-lg bg-cyan-500 flex flex-col justify-center min-h-screen sm:min-h-fit sm:rounded-md"
    >
      <h1 class="text-4xl text-slate-200 mb-7 font-semibold">Reset password</h1>
      <h3 class="text-md text-slate-200 mb-7 font-normal">
        Please, enter a new password. If you have not requested this password
        change, please ignore this page.
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
        @submit.prevent="resetPassword(resetPasswordForm)"
        class="flex flex-col justify-center gap-y-2"
      >
        <FormInputComponent
          v-model="resetPasswordForm.password"
          input-label="Password"
          :input-rules="[rules.required, rules.password]"
          :input-append-inner-icon="
            showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'
          "
          @click:append-inner="showPassword = !showPassword"
          :input-type="showPassword ? 'text' : 'password'"
        />
        <FormInputComponent
          v-model="resetPasswordForm.confirm_password"
          input-label="Confirm password"
          :input-rules="[
            rules.required,
            rules.confirmPassword(resetPasswordForm.password),
          ]"
          input-type="password"
          @paste="
            (e) => {
              e.preventDefault();
            }
          "
        />

        <SubmitButtonComponent button-label="Change password" />
      </v-form>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { useUserStore } from "@/stores/UserStore";
import router from "../router/index";
import SubmitButtonComponent from "@/components/SubmitButtonComponent.vue";
import FormInputComponent from "@/components/FormInputComponent.vue";
import ErrorComponent from "@/components/ErrorComponent.vue";
import SuccessComponent from "@/components/SuccessComponent.vue";
import rules from "@/utils/rules";
import { useRoute } from "vue-router";

const form = ref(null);
const route = useRoute();
const showError = ref(false);
const errorMessage = ref(null);
const showSuccess = ref(false);
const successMessage = ref(null);
const showPassword = ref(false);
const resetPasswordForm = ref({
  password: null,
  confirm_password: null,
  token: route.params.token,
});

const userStore = useUserStore();

async function resetPassword(dataForm) {
  showError.value = false;
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await userStore.resetPassword(dataForm);
      showSuccess.value = true;
      successMessage.value = result.message;

      setTimeout(() => {
        router.push({ name: "login" });
      }, 3000);
    } catch (err) {
      console.log(err);
      showError.value = true;
      errorMessage.value = err.response.data.error;
    }
  }
}
</script>

<style scoped></style>
