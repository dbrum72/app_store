<template>
    <div class="header">
        <div class="title mb-2">
            <div class="logo">
                <img src="@/assets/logo.png">
                <router-link :to="{ name: 'Ecommerce' }">
                    <h1>{{ $myEcommerce }}</h1>
                </router-link>
            </div>
            <div class="position-relative">
                <input type="text" class="form-control pe-5" id="filterProduct"
                    placeholder="O que você está procurando?" v-model="searchQuery">
                <router-link
                    :to="{ name: 'Ecommerce', query: { filter: searchQuery, extendedFilter: null, parameter: 'name', sort: 'updated_at DESC' } }"
                    class="position-absolute top-50 end-0 translate-middle-y me-3 text-decoration-none text-muted">
                    <i class="fa-solid fa-magnifying-glass"></i> </router-link>
            </div>
            <div class="user-options me-3">
                <div v-if="isLogged">
                    <i class="fas fa-user"></i>
                    <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ GET_USERNAME }}
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" @click="goToAdmin()">Administraçao</a></li>
                        <li><a class="dropdown-item" @click="submitLogout()">Sair</a></li>
                    </ul>
                </div>
                <div v-else>
                    <router-link :to="{ name: 'Login' }"><i class="fa-solid fa-arrow-right-to-bracket"></i>Entre ou
                        Cadastre-se</router-link>
                </div>
            </div>
            <div class="btn-cart" :class="countCart ? '' : ' empty'">
                <span class="mb-1">{{ countCart }}</span>
                <span class="label"><i class="fa-solid fa-cart-shopping"></i></span>
            </div>
        </div>
        <nav>
            <router-link
                :to="{ name: 'Ecommerce', query: { filter: null, extendedFilter: 'category,Notebooks', parameter: 'tree', sort: 'updated_at DESC' } }">Notebooks</router-link>
            <router-link
                :to="{ name: 'Ecommerce', query: { filter: null, extendedFilter: 'category,SSDs', parameter: 'tree', sort: 'updated_at DESC' } }">SSDs</router-link>
            <router-link
                :to="{ name: 'Ecommerce', query: { filter: null, extendedFilter: 'category,Periféricos', parameter: 'tree', sort: 'updated_at DESC' } }">Periféricos</router-link>
            <router-link to="">Acessórios</router-link>
            <router-link to="">Promoções</router-link>
        </nav>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'

export default {

    name: 'HeaderBar',

    mixins: [AbstractMixin, ProductMixin],

    data() {
        return {
            searchQuery: ''
        };
    },

    computed: {
        ...mapGetters([
            'isLogged',
            'GET_USERNAME',
            'countCart'
        ])
    },

    methods: {
        ...mapActions(['logout']),

        async submitLogout() {
            this.SET_LOADER({ 'active': true, 'text': 'Processando...' })
            try {
                await this.logout();
                this.$router.push({ name: "Ecommerce" });
            } catch (error) {
                console.error("Erro no logout:", error);
            }
            finally {
                this.SET_LOADER({ 'active': false, 'text': '' })
            }
        },

        goToAdmin() {
            this.$router.push({ name: 'AdminIndex' })
        }
    }
}
</script>

<style scoped>
.btn-cart {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
    height: 60px;
    width: 60px;
    font-size: 1.4rem;
    border-radius: 50%;
    cursor: pointer;
    color: #5AE8C9;
    text-decoration: none;
    text-shadow: 2px 2px 2px #000;
    box-shadow: 2px 2px 5px 0 rgba(0, 0, 0, 0.75);
    background: #203041;
}

.dropdown-item:hover {
    color: #203041;
    background-color: #D9FEF1;
    cursor: pointer;
}

.dropdown-menu {
    border: solid 2px #41B883;
    background-color: #203041 !important;
}

.empty {
    text-shadow: none;
    color: #fff;
}

.header {
    margin: 0 auto;
    padding: 10px;
    display: flex;
    flex-direction: column;
}

h1 {
    font-size: 1.5rem;
    white-space: nowrap;
    color: #41B883;
    /*text-shadow: 1px 1px 0px #FFFFFF;*/
}

i {
    color: #41B883;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo a {
    text-decoration: none;
}

.logo img {
    width: 40px;
}

nav {
    display: flex;
    gap: 20px;
    justify-content: center;
    align-items: center;
}

nav a {
    color: #879FC4;
    text-decoration: none;
}

.title {
    display: flex;
    justify-content: space-between;
}

ul {
    padding: 0;
}

.user-options {
    display: flex;
    flex-flow: row nowrap;
    align-items: center;
    gap: 15px;
    white-space: nowrap
}

.user-options a {
    color: #fff;
    text-decoration: none;
}

.user-options i {
    margin-right: 10px;
}

.user-options input[type='text'] {
    padding: 5px;
    border: solid 2px #41B883;
    border-radius: 5px;
}

.user-options span {
    color: #fff;
}

.user-options span:hover {
    cursor: pointer;
}
</style>