<template>
    <div class="navbar">
        <router-link :to="{ name: 'Produtos' }">Todos os produtos</router-link>
        <router-link :to="{ name: 'User' }">Usuário</router-link>
        <router-link :to="{ name: 'Sobre' }">Sobre</router-link>
    </div>
</template>

<script>
export default {

    name: "AppNavbar",

    methods: {}
}
</script>

<style scoped>
.navbar {
    grid-area: appNavbar;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #2f465f;
    
}

a {
    padding: 0.5rem;
    text-decoration: none;
    font-weight: bold;
    color: #ececec;
}

a:hover {
    color: #5AE2A5;
}

a.router-link-exact-active {
    color: #5AE2A5;
}
</style>