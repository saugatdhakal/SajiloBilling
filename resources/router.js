import { createRouter, createWebHashHistory } from 'vue-router';
import Login from './views/login/login.vue';
import Home from './views/home/home.vue';
import AppLayout from './layouts/appLayout.vue';
import {authState} from '../resources/states/auth'
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/user',
        name: 'user',
        component:()=> import('./views/user/user.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/user/adduser',
        name: 'adduser',
        component:()=> import('./views/user/userAdd.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },

];

const router = createRouter({
    mode: 'history',
    history: createWebHashHistory(),
    routes
});
router.beforeEach(async (to) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login'];

    const authRequired = !publicPages.includes(to.path);
    const auths = authState(); //State Management
    if (authRequired && !auths.isAuth) {
        auths.returnUrl = to.fullPath;
        return '/login';
    }
});
export default router;
