import { createApp } from 'vue';
import { createPinia } from 'pinia';
import root from '../layouts/app.vue';
import router from '../router';
import Toaster from "@meforma/vue-toaster";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const pinia = createPinia();
const app = createApp(root);

app.use(pinia);
app.use(router);
app.use(VueSweetalert2);
app.use(Toaster, {
    position: 'top-right'
}).provide('toast', app.config.globalProperties.$toast)
router.isReady().then(() => {
    app.mount('#app');
})
import "bootstrap/dist/js/bootstrap.js"

