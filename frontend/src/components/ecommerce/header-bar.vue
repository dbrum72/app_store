<template>
    <div class="header">
        <div class="title">
            <div class="logo">
                <img src="@/assets/logo.png">
                <h1>{{ $myEcommerce }}</h1>
            </div>
            <div class="user-options">
                <router-link :to="{ name: 'Login' }"><i class="fas fa-user"></i>Login / Cadastro</router-link>
                <a href=""></a>
                <a href=""></a>
            </div>
        </div>
        <nav>
            <router-link to="">Computadores</router-link>
            <router-link to="">TVs</router-link>
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
export default {

    name: 'HeaderBar',
}
</script>

<style>
h1 {
    font-size: 1.5rem;
    white-space: nowrap;
    color: #08EFB0;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
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

.user-options input[type='text'] {
    padding: 5px;
    border: solid 2px #41B883;
    border-radius: 5px;
}
</style>