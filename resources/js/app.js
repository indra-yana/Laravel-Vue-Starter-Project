import { createApp } from 'vue'

import "@src/plugin/bootstrap";
import AppTemplate from "@layouts/AppTemplate.vue";
import router from '@src/router/router';
import { createPinia } from 'pinia';
import persitedState from '@src/plugin/persistedState';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import axios from '@src/plugin/axios.js';
import mitt from 'mitt';

// Global Components
import SubmitButton from "@components/SubmitButton.vue";
import ResetButton from "@components/ResetButton.vue";
import SaveButton from "@components/SaveButton.vue";
import Loader from "@components/LoaderSpinner.vue";

const app = createApp(AppTemplate);
const emitter = mitt();
const pinia = createPinia();
// pinia.use(persitedState);
pinia.use(piniaPluginPersistedstate);

// Registering Global Component
app.component("SubmitButton", SubmitButton)
    .component("SaveButton", SaveButton)
    .component("ResetButton", ResetButton)
    .component("Loader", Loader);

// Registering App Plugin
app.config.globalProperties.$event = emitter;
app.config.globalProperties.$axios = axios;
app.provide('axios', app.config.globalProperties.axios);
app.use(router);
app.use(pinia);

// Mounting app
app.mount('#app');
