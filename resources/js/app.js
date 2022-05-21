import { createApp } from 'vue'

import "./bootstrap";
import AppTemplate from "./layouts/AppTemplate.vue";
import router from './router';

// Global Components
import Alert from "./components/Alert.vue";
import SubmitButton from "./components/SubmitButton.vue";
import ResetButton from "./components/ResetButton.vue";

const app = createApp(AppTemplate);

// Registering Global Component
app.component("Alert", Alert)
    .component("SubmitButton", SubmitButton)
    .component("ResetButton", ResetButton);

// Registering Router
app.use(router);

// Mounting app
app.mount('#app');
