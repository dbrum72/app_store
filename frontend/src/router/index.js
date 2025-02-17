import { createRouter, createWebHashHistory } from 'vue-router'
import { jwtDecode } from "jwt-decode";
import store from "@/store"


const routes = [
    {
        path: '/:catchAll(.*)',
        redirect: { name: 'Shop' }
    },
    {
        path: '/',
        name: 'Shop',
        component: () => import(/* webpackChunkName: "home" */ '@/views/shop/IndexView.vue')
    },
    {
        path: '/carrinho',
        name: 'Carrinho',
        meta: { auth: true },
        component: () => import('@/views/shop/cart-view.vue')
    },    
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/views/LoginView.vue')
    },
    {
        path: '/meus-dados',
        name: 'MeusDados',
        meta: { auth: true },
        component: () => import('@/views/MeusDadosView.vue')
    },
    {
        path: '/logout',
        name: 'Logout',
        meta: { auth: true },
        component: () => import('@/views/LoginView.vue')
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import(/* webpackChunkName: "dashboard" */ '@/views/DashboardView.vue')
    },
    {
        path: '/produtos',
        name: 'Produtos',
        component: () => import('@/views/shop/OrderView.vue')
    },  
    {
        path: '/sobre',
        name: 'Sobre',
        component: () => import(/* webpackChunkName: "sobre" */ '@/views/SobreView.vue')
    },
    {
        path: '/user',
        name: 'User',
        meta: { auth: true },
        component: () => import(/* webpackChunkName: "sobre" */ '@/views/UserView.vue')
    },
    {
        path: '/admin',
        name: 'AdminIndex',
        meta: { auth: true },
        component: () => import('@/views/admin/AdminIndex.vue'),
        children: [
            {
                path: 'categoria',
                name: 'Category',
                meta: { auth: true },
                component: () => import('@/views/admin/CategoryView.vue')
            },
            {
                path: 'clients',
                name: 'getClients',
                meta: { auth: true },
                component: () => import('@/views/admin/client/getClients.vue'),
                children: [
                    {
                        path: 'addresses',
                        name: 'getAddresses',
                        meta: { auth: true },
                        component: () => import('@/views/admin/address/getAddresses.vue'),
                        children: [
                            {
                                path: 'show',
                                name: 'getAddress',
                                meta: { auth: true },
                                component: () => import('@/views/admin/address/getAddress.vue')
                            },
                            {
                                path: 'save/:id?',
                                name: 'saveAddress',
                                meta: { auth: true },
                                component: () => import('@/views/admin/address/saveAddress.vue')
                            }
                        ]
                    },
                    {
                        path: 'endereco',
                        name: 'getAddresses',
                        meta: { auth: true },
                        component: () => import('@/views/admin/address/getAddresses.vue')
                    },
                ]
            },
            {
                path: 'client/save/:id?',
                name: 'saveClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/saveClient.vue')
            },
            {
                path: 'client/delete/:id',
                name: 'deleteClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/deleteClient.vue')
            },
            {
                path: 'client/show/:id',
                name: 'showClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/showClient.vue')
            },           
            {
                path: 'estoque',
                name: 'Stock',
                meta: { auth: true },
                component: () => import('@/views/admin/StockView.vue')
            },
            {
                path: 'produto',
                name: 'Product',
                meta: { auth: true },
                component: () => import('@/views/admin/ProductView.vue')
            },
            
        ]
    },
    {
        path: '/loja',
        name: 'Shop',
        component: () => import('@/views/shop/IndexView.vue'),
        children: [
            {
                path: 'ordem',
                name: 'Order',
                meta: { auth: true },
                component: () => import('@/views/shop/OrderView.vue')
            }
        ]
    }
]

const router = createRouter({
    history: createWebHashHistory(process.env.BASE_URL),
    routes
})

router.beforeEach((to, from, next) => {

    if (to.meta?.auth) {
        const token = document.cookie.split("; ").find((row) => row.startsWith("token="))?.split("=")[1];
        if (token) {
            var decoded = jwtDecode(token);
            if (Date.now() / 1000 > decoded.exp) {
                store.commit('SET_USER', null)
                next({ name: 'Login' });
            } else {
                next()
            }
        } else {
            store.commit('SET_USER', null)
            next({ name: 'Login' });
        }
    } else {
        next();
    }

    document.title = process.env.VUE_APP_TITLE.toUpperCase() + ' - ' + to.name
})

export default router
