import { createRouter, createWebHashHistory } from 'vue-router';
import Login from './views/login/login.vue';
import Home from './views/home/home.vue';
import AppLayout from './layouts/appLayout.vue';

const routes = [
    //Home
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            layout: AppLayout
        }
    },
    //Login
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
    },
    {
        path: '/supplier/softDelete',
        name: 'supplierSoftDelete',
        component: () => import('./views/suppliers/supplierSoftDelete.vue'),
        meta: {
            layout: AppLayout
        }
    },
    // Product
    {
        path: '/product',
        name: 'product',
        component: () => import('./views/product/productDashboard.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/product/create',
        name: 'productCreate',
        component: () => import('./views/product/productCreate.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/product/edit/:id',
        name: 'productEdit',
        component: () => import('./views/product/productEdit.vue'),
        meta: {
            layout: AppLayout
        },
        props: true
    },
    {
        path: '/product/softDelete',
        name: 'productSoftDelete',
        component: () => import('./views/product/productSoftDelete.vue'),
        meta: {
            layout: AppLayout
        },
    },
    // Purchase
    {
        path: '/purchase',
        name: 'purchase',
        component: () => import('./views/purchase/purchaseDashboard.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/purchase/create',
        name: 'purchaseCreate',
        component: () => import('./views/purchase/purchaseCreate.vue'),
        meta: {
            layout: AppLayout
        }
    },
    {
        path: '/purchase/edit/:id',
        name: 'purchaseEdit',
        component: () => import('./views/purchase/purchaseEdit.vue'),
        meta: {
            layout: AppLayout
        },
        props: true
    },
    {
        path: '/purchase/softdelete',
        name: 'purchaseSoftDelete',
        component: () => import('./views/purchase/purchaseSoftDelete.vue'),
        meta: {
            layout: AppLayout
        }

    },
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
