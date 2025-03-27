<template>
    <div class="header">
        <div class="title">
            <div class="logo">
                <img src="@/assets/logo.png">
                <router-link :to="{ name: 'Ecommerce' }">
                    <h1>{{ $myEcommerce }}</h1>
                </router-link>
            </div>
            <div class="user-options me-3">
                <div v-if="isLogged">
                    <i class="fas fa-user"></i>
                    <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ GET_USERNAME }}
                    </span>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" @click="goToAdmin()">Administraçao</a></li>
                        <li><a class="dropdown-item" @click="logout()">Sair</a></li>
                    </ul>
                </div>
                <div v-else>
                    <router-link :to="{ name: 'Login' }"><i class="fa-solid fa-arrow-right-to-bracket"></i>Entre ou
                        Cadastre-se</router-link>
                </div>
            </div>
        </div>
        <nav>
            <router-link
                :to="{ name: 'Ecommerce', query: { filter: 'tree', parameter: 'Notebooks' } }">Notebooks</router-link>
            <router-link :to="{ name: 'Ecommerce', query: { filter: 'tree', parameter: 'SSDs' } }">SSDs</router-link>
            <router-link
                :to="{ name: 'Ecommerce', query: { filter: 'tree', parameter: 'Periféricos' } }">Periféricos</router-link>
            <router-link to="">Acessórios</router-link>
            <router-link to="">Promoções</router-link>
            <div>
                <input type="text" placeholder="Buscar produto">
                <i class="fas fa-search"></i>
            </div>

        </nav>
    </div>
</template>

<script>
import { mapGetters } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin'

export default {

    name: 'HeaderBar',

    mixins: [AbstractMixin],

    computed: {
        ...mapGetters([
            'isLogged',
            'GET_USERNAME'
        ])
    },

    methods: {
        goToAdmin() {
            this.$router.push({ name: 'AdminIndex' })
        }
    }
}
</script>

<style scoped>
.dropdown-item:hover {
    color: #203041;
    background-color: #52D9A9;
    cursor: pointer;
}

.dropdown-menu {
    border: solid 2px #41B883;
    background-color: #203041 !important;
}

h1 {
    font-size: 1.5rem;
    white-space: nowrap;
    color: #41B883;
    text-shadow: 1px 1px 0px #FFFFFF;

}

i {
    color: #fff;
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