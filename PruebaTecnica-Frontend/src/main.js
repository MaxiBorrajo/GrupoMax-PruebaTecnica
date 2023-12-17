import { createApp } from "vue";
import { createPinia } from "pinia";
import "vuetify/styles";

import { createVuetify } from "vuetify";

import * as components from "vuetify/components";

import * as directives from "vuetify/directives";

import { aliases, fa } from "vuetify/iconsets/fa";

import { mdi } from "vuetify/iconsets/mdi";
import App from "./App.vue";
import "./index.css";
import router from "./router";

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: "fa",
    aliases,
    sets: {
      fa,
      mdi,
    },
  },
});

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(vuetify);
app.mount("#app");
