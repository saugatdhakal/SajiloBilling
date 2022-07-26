import "bootstrap/dist/css/bootstrap.min.css"
import {createApp} from 'vue';
import { createPinia } from 'pinia';
import root from '../layouts/app.vue';
import router  from '../router';


const pinia = createPinia();
const app = createApp(root);

app.use(pinia);
app.use(router);
app.mount('#app');
import "bootstrap/dist/js/bootstrap.js"
