<template>
    <div class="navbar" v-show="isNavbarVisible">
        <div id="nav">
            <div><router-link :to="{ name: 'Ecommerce' }">Início</router-link></div>            
            <div><router-link :to="{ name: 'getProducts' }">Produtos</router-link></div>
            <div><router-link :to="{ name: 'getMovements' }">Movimentações</router-link></div>
            <div><router-link :to="{ name: 'getCategories' }">Categorias</router-link></div>
            <div><router-link :to="{ name: 'getUsers' }">Usuários</router-link></div>
        </div>
    </div>
</template>

<script>
import { mapMutations, mapState } from "vuex";

export default {

    name: "AdminBar",

    computed: mapState(['isNavbarVisible']),

    methods: {

        ...mapMutations(['SET_TOGGLE_MENU']),
    }
}
</script>

<style scoped>
.navbar {
    display: flex;
    flex-flow: column nowrap; 
    justify-content: flex-start;
    align-items: center;
    padding: 20px;
    background: linear-gradient(180deg, rgba(66, 111, 166, 1) 20%, rgba(103, 186, 104, 1) 80%);
}

#nav {
    display: flex;
    flex-flow: column nowrap;
    justify-content: flex-start;
    align-items: center;
}

#nav a {
    text-decoration: none;
    letter-spacing: 1px;
    color: #fff;
}

#nav div {
    margin-bottom: 10px;
}

nav a.router-link-exact-active {
    color: #5AE2A5;
}
</style>