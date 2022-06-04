import { createApp } from 'vue'

import "./bootstrap";
import AppTemplate from "./layouts/AppTemplate.vue";
import router from './router';
import { createPinia } from 'pinia';
import persitedState from './plugin/persistedState';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import axios from './plugin/axios';
import mitt from 'mitt';

// Global Components
import SubmitButton from "./components/SubmitButton.vue";
import ResetButton from "./components/ResetButton.vue";

const app = createApp(AppTemplate);
const emitter = mitt();
const pinia = createPinia();
// pinia.use(persitedState);
pinia.use(piniaPluginPersistedstate);

// Registering Global Component
app.component("SubmitButton", SubmitButton)
    .component("ResetButton", ResetButton);

// Registering App Plugin
app.config.globalProperties.$event = emitter;
app.config.globalProperties.$axios = axios;
app.provide('axios', app.config.globalProperties.axios);
app.use(router);
app.use(pinia);

// Mounting app
app.mount('#app');
