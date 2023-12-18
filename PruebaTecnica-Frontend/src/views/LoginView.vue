<template>
  <section class="flex justify-center items-center bg-slate-200 min-h-screen">
    <div
      class="w-96 p-8 shadow-lg bg-cyan-500 flex flex-col justify-center min-h-screen sm:min-h-fit
      sm:rounded-md"
    >
      <h1 class="text-4xl text-slate-200 mb-7 font-semibold">Login CRM</h1>
      <ErrorComponent v-if="showError" :error-message="errorMessage" class="mb-7"/>
      <v-form
        ref="form"
        @submit.prevent="login(loginForm)"
        class="flex flex-col justify-center gap-y-2"
      >
        <FormInputComponent
          v-model="loginForm.email"
          input-label="Email"
          :input-rules="[rules.required]"
          input-type="email"
        />
        <FormInputComponent
          v-model="loginForm.password"
          input-label="Password"
          :input-rules="[rules.required]"
          :input-append-inner-icon="
            showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'
          "
          @click:append-inner="showPassword = !showPassword"
          :input-type="showPassword ? 'text' : 'password'"
        />
        <span class="mb-3 flex flex-col gap-y-2">
          <router-link
            :to="{ name: 'register' }"
            class="text-slate-800 text-md font-light hover:text-slate-100"
          >
            Doesn't have an account?
          </router-link>
          <router-link
            :to="{ name: 'forgotPassword' }"
            class="text-slate-800 text-md font-light hover:text-slate-100"
          >
            Forgot password?
          </router-link>
        </span>
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
import rules from "@/utils/rules";
import VueCookies from "vue-cookies";
const form = ref(null);

const showError = ref(false);
const errorMessage = ref(null);

const loginForm = ref({
  email: null,
  password: null,
});

const userStore = useUserStore();

const showPassword = ref(false);

async function login(dataForm) {
  const { valid } = await form.value.validate();

  if (valid) {
    try {
      const result = await userStore.login(dataForm);
      
      VueCookies.set("user",result.resource);
      VueCookies.set("token", result.token);

      router.push({ name: "dashboard" });
    } catch (err) {
      console.log(err);
      showError.value = true;
      errorMessage.value = err.response.data.error;
    }
  }
}
</script>

<style scoped>
</style>
