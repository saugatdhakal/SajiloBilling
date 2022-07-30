import { createApp } from 'vue';
import { createPinia } from 'pinia';
import root from '../layouts/app.vue';
import router from '../router';
import Toaster from "@meforma/vue-toaster";

const pinia = createPinia();
const app = createApp(root);

app.use(pinia);
app.use(router);
app.use(Toaster, {
    position: 'top-right'
}).provide('toast', app.config.globalProperties.$toast)
app.mount('#app');
import "bootstrap/dist/js/bootstrap.js";

