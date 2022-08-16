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
        path: '/login',
        name: 'login',
        component: Login
    },
    // User Pages
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
        path: '/user/edit/:id',
        name: 'editUser',
        component: () => import('./views/user/userEdit.vue'), //Lazy-loading
        meta: {
            layout: AppLayout
        },
        props: true,

    },
    // Account Pages
    {
        path: '/account',
        name: 'account',
        component: () => import('./views/account/accountIndex.vue'),
        meta: {
            layout: AppLayout
        },
        props: true

    },

    {
        path: '/account/create',
        name: 'accountCreate',
        component: () => import('./views/account/accountCreate.vue'),
        meta: {
            layout: AppLayout
        },
        props: true

    },
    {
        path: '/account/edit/:id',
        name: 'accountEdit',
        component: () => import('./views/account/accountEdit.vue'),
        meta: {
            layout: AppLayout
        },
        props: true

    },
    {
        path: '/account/softDelete',
        name: 'accountSoftDelete',
        component: () => import('./views/account/accountSoftDelete.vue'),
        meta: {
            layout: AppLayout
        },
    },

    // Suppliers

    {
        path: '/supplier',
        name: 'supplier',
        component: () => import('./views/suppliers/supplierDashboard.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/supplier/create',
        name: 'supplierCreate',
        component: () => import('./views/suppliers/supplierCreate.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/supplier/edit/:id',
        name: 'supplierEdit',
        component: () => import('./views/suppliers/supplierEdit.vue'),
        meta: {
            layout: AppLayout
        }, props: true
    }
];

const router = createRouter({

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

    const publicPages = ['/login'];
    const authRequired = !publicPages.includes(to.path);
    if (authRequired && !localStorage.getItem('token')) {
        return '/login';
    }
});

export default router;
