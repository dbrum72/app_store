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
        component: () => import(/* webpackChunkName: "home" */ '@/views/shop/shop-index.vue')
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
        component: () => import('@/views/shop/shop-index.vue')
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
                path: 'cliente',
                name: 'Client',
                meta: { auth: true },
                component: () => import('@/views/admin/ClientView.vue')
            },
            {
                path: 'cliente-endereco',
                name: 'ClientAddress',
                meta: { auth: true },
                component: () => import('@/views/admin/ClientAddressView.vue')
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
