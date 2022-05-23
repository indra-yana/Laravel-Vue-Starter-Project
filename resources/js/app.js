import { createApp } from 'vue'

import "./bootstrap";
import AppTemplate from "./layouts/AppTemplate.vue";
import router from './router';
import { createPinia } from 'pinia'
import persitedState from './plugin/persistedState'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

// Global Components
import Alert from "./components/Alert.vue";
import SubmitButton from "./components/SubmitButton.vue";
import ResetButton from "./components/ResetButton.vue";

const app = createApp(AppTemplate);
const pinia = createPinia();
// pinia.use(persitedState);
pinia.use(piniaPluginPersistedstate);

// Registering Global Component
app.component("Alert", Alert)
    .component("SubmitButton", SubmitButton)
    .component("ResetButton", ResetButton);

// Registering App Plugin
app.use(router);
app.use(pinia);

// Mounting app
app.mount('#app');
