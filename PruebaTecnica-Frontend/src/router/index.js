import { createRouter, createWebHistory } from "vue-router";
import VueCookies from "vue-cookies";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import ForgotPasswordView from "../views/ForgotPasswordView.vue";
import ResetPasswordView from "../views/ResetPasswordView.vue";
import UserView from "../views/UserView.vue";
import ClientView from "../views/ClientView.vue";
import CreateClientView from "../views/CreateClientView.vue";
import DashboardView from "../views/DashboardView.vue";
import ErrorView from "../views/ErrorView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      redirect: { name: "login" },
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
      meta: {
        noAuth: true,
      },
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
      meta: {
        noAuth: true,
      },
    },
    {
      path: "/forgotPassword",
      name: "forgotPassword",
      component: ForgotPasswordView,
      meta: {
        noAuth: true,
      },
    },
    {
      path: "/resetPassword/:token",
      name: "resetPassword",
      component: ResetPasswordView,
      meta: {
        noAuth: true,
      },
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: DashboardView,
      meta: {
        requireAuth: true,
      },
    },
    {
      path: "/profile",
      name: "profile",
      component: UserView,
      meta: {
        requireAuth: true,
      },
    },
    {
      path: "/createClient",
      name: "createClient",
      component: CreateClientView,
      meta: {
        requireAuth: true,
      },
    },
    {
      path: "/client/:id",
      name: "client",
      component: ClientView,
      meta: {
        requireAuth: true,
      },
    },
    {
      path: "/:catchAll(.*)",
      name: "Error",
      component: ErrorView,
      pathMatch: "prefix",
    },
  ],
});

router.beforeEach(async (to, from, next) => {
  const requireAuth = to.meta.requireAuth;
  const noAuth = to.meta.noAuth;

  if (requireAuth && !VueCookies.isKey("token")) {
    return next({ name: "login" });
  }

  if (noAuth && VueCookies.isKey("token")) {
    return next({ name: "dashboard" });
  }

  return next();
});

export default router;
