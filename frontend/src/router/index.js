import { createRouter, createWebHashHistory } from 'vue-router'
import { jwtDecode } from "jwt-decode";
import store from "@/store"


const routes = [
    {
        path: '/ecommerce',
        name: 'Ecommerce',
        component: () => import('@/views/ecommerce/IndexView.vue')      
    },
    {
        path: '/ecommerce/product/:id',
        name: 'ProductView',
        component: () => import('@/views/ecommerce/getProduct.vue')
    },
    {
        path: '/carrinho',
        name: 'Carrinho',
        meta: { auth: true },
        component: () => import('@/views/ecommerce/cart-view.vue')
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/views/login-view.vue')
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
        component: () => import('@/views/login-view.vue')
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import(/* webpackChunkName: "dashboard" */ '@/views/DashboardView.vue')
    },
    {
        path: '/produtos',
        name: 'Produtos',
        component: () => import('@/views/ecommerce/OrderView.vue')
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
        path: '/user/register',
        name: 'UserRegister',
        component: () => import('@/views/user-register.vue')
    },
    {
        path: '/admin',
        name: 'AdminIndex',
        meta: { auth: true },
        component: () => import('@/views/admin/AdminIndex.vue'),
        children: [
            {
                path: 'categories',
                name: 'getCategories',
                meta: { auth: true },
                component: () => import('@/views/admin/category/getCategories.vue')
            },
            {
                path: 'category/new',
                name: 'newCategory',
                meta: { auth: true },
                component: () => import('@/views/admin/category/newCategory.vue')
            },
            {
                path: 'category/show/:id',
                name: 'getCategory',
                meta: { auth: true },
                component: () => import('@/views/admin/category/getCategory.vue')
            },
            {
                path: 'category/edit/:id',
                name: 'editCategory',
                meta: { auth: true },
                component: () => import('@/views/admin/category/editCategory.vue')
            },
            {
                path: 'category/delete/:id',
                name: 'deleteCategory',
                meta: { auth: true },
                component: () => import('@/views/admin/category/deleteCategory.vue')
            },
            
            {
                path: 'clients',
                name: 'getClients',
                meta: { auth: true },
                component: () => import('@/views/admin/client/getClients.vue'),
            },
            {
                path: 'client/new',
                name: 'newClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/newClient.vue')
            },
            {
                path: 'client/edit/:id',
                name: 'editClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/editClient.vue')
            },
            {
                path: 'client/delete/:id',
                name: 'deleteClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/deleteClient.vue')
            },
            {
                path: 'client/show/:id',
                name: 'getClient',
                meta: { auth: true },
                component: () => import('@/views/admin/client/getClient.vue')
            },
            {
                path: 'client/address/new/:client_id',
                name: 'newAddress',
                meta: { auth: true },
                component: () => import('@/views/admin/client/newAddress.vue')
            },
            {
                path: 'client/address/edit/:id',
                name: 'editAddress',
                meta: { auth: true },
                component: () => import('@/views/admin/client/editAddress.vue')
            },
            {
                path: 'client/address/delete/:id',
                name: 'deleteAddress',
                meta: { auth: true },
                component: () => import('@/views/admin/client/deleteAddress.vue')
            },            
            {
                path: 'products',
                name: 'getProducts',
                meta: { auth: true },
                component: () => import('@/views/admin/product/getProducts.vue')
            },
            {
                path: 'product/new',
                name: 'newProduct',
                meta: { auth: true },
                component: () => import('@/views/admin/product/newProduct.vue')
            },
            {
                path: 'product/show/:id',
                name: 'getProduct',
                meta: { auth: true },
                component: () => import('@/views/admin/product/getProduct.vue')
            },
            {
                path: 'product/edit/:id',
                name: 'editProduct',
                meta: { auth: true },
                component: () => import('@/views/admin/product/editProduct.vue')
            },
            {
                path: 'product/delete/:id',
                name: 'deleteProduct',
                meta: { auth: true },
                component: () => import('@/views/admin/product/deleteProduct.vue')
            },
            {
                path: 'movements',
                name: 'getMovements',
                meta: { auth: true },
                component: () => import('@/views/admin/movement/getMovements.vue')
            },
            {
                path: 'movement/new',
                name: 'newMovement',
                meta: { auth: true },
                component: () => import('@/views/admin/movement/newMovement.vue')
            },
            {
                path: 'movement/edit/:id',
                name: 'editMovement',
                meta: { auth: true },
                component: () => import('@/views/admin/movement/editMovement.vue')
            },
            {
                path: 'movement/show/:id',
                name: 'getMovement',
                meta: { auth: true },
                component: () => import('@/views/admin/movement/getMovement.vue')
            },
            {
                path: 'movement/delete/:id',
                name: 'deleteMovement',
                meta: { auth: true },
                component: () => import('@/views/admin/movement/deleteMovement.vue')
            }            
        ]
    },
    {
        path: '/:catchAll(.*)',
        redirect: { name: 'Ecommerce' }
    },
    
]

const router = createRouter({
    history: createWebHashHistory(process.env.BASE_URL),
    routes
})

router.beforeEach((to, from, next) => {

    if (to.meta?.auth) {
        const token = localStorage.getItem('token') || null;
        if (token) {
            var decoded = jwtDecode(token);
            if (Date.now() / 1000 > decoded.exp) {
                store.commit('SET_USER', null)
                next({ name: 'Login' });
            } 
            next()
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
