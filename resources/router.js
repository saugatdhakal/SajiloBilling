import { createRouter, createWebHashHistory } from 'vue-router';
import Login from './views/login/login.vue';
import Home from './views/home/home.vue';
import AppLayout from './layouts/appLayout.vue';
import { authState } from '../resources/states/auth';


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
        component: () => import('./views/user/user.vue'),
        meta: {
            layout: AppLayout
        },
        props: true

    },
    {
        path: '/user/adduser',
        name: 'adduser',
        component: () => import('./views/user/userAdd.vue'), //Lazy-loading
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

// router.beforeEach((to, from, next) => {

//     if (to.matched.some(record => record.meta.requiresAuth)) {

//       // this route requires auth, check if logged in
//       // if not, redirect to login page.
//       if (!auths.isAuth) {
//         next({
//             name: 'login'
//         })
//       } else {
//         next()
//       }
//     }
//     if (to.matched.some(record => record.meta.requiresAdmin)) {
//       // this route requires auth, check if logged in
//       // if not, redirect to home page.
//       if (!store.getters.loggedUser.type == 'admin') {
//         next({
//             name: 'home'
//         })
//       } else {
//         next()
//       }
//     }
//      else {
//       next() // make sure to always call next()!
//     }
// })

router.beforeEach(async (to) => {
    // const auths = authState(); //State Management (Pinia)
    const publicPages = ['/login'];
    const authRequired = !publicPages.includes(to.path);
    if (authRequired && !localStorage.getItem('token')) {
        auths.returnUrl = to.fullPath;
        return '/login';
    }
});

export default router;
