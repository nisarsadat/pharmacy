import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "@/App.vue";
import router from "@/router";
import vuetify from "@/plugins/vuetify";
import Toastify from "vue3-toastify";

import "@/plugins/axios";
import "vue3-toastify/dist/index.css";
import "vuetify/styles";
import '@mdi/font/css/materialdesignicons.css';
const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(vuetify);
app.use(Toastify, {
    autoClose: 2500,
    position: "top-right",
    rtl: true,
});

app.mount("#app");