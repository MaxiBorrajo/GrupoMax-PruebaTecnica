<template>
  <section class="flex justify-center items-center h-screen bg-slate-200">
    <div class="w-96 p-6 shadow-lg bg-cyan-500 flex flex-col justify-center gap-y-5 form-container">
      <h1>Login CRM</h1>
      <v-form ref="form" @submit.prevent="login(loginForm)" class="flex flex-col justify-center gap-y-3">
        <FormInputComponent
          v-model="loginForm.email"
          input-label="Email"
          :input-rules="[rules.required]"
          input-type="email"
        />
        <FormInputComponent
          v-model="loginForm.password"
          input-label="Password"
          :input-rules="[rules.required, rules.password]"
          :input-append-inner-icon="
            showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'
          "
          @click:append-inner="showPassword = !showPassword"
          :input-type="showPassword ? 'text' : 'password'"
        />
        <p
          @click="router.push({ name: 'ForgotPassword' })"
          style="cursor: pointer"
        >
          Forgot password?
        </p>
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
import rules from "@/utils/rules";
import VueCookies from "vue-cookies";
const form = ref(null);

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

      VueCookies.VueCookies.set("token", result.resource.token);

      router.push({ name: "Dashboard" });
    } catch (err) {
      alert(err);
    }
  }
}
</script>

<style scoped></style>
