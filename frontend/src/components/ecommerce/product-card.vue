<template>
    <div class="card">
        <BreadcrumbBar :tree="tree" />

        <div class="card-img">
            <img :src="src" :alt="name" />
        </div>
        <div class="card-title">
            <h6>{{ name }}</h6>
        </div>
        <div class="card-description">{{ description }}</div>
        <div class="card-price">R$ {{ price }}</div>
        <div class="view-details">
            <router-link :to="{ name: 'ProductView', params: { 'id': id } }">
                <button> Ver detalhes</button>
            </router-link>
        </div>
    </div>
</template>

<script>
import BreadcrumbBar from '@/components/bars/breadcrumb-bar.vue'

export default {
    name: 'ProductCard',

    props: [
        'id',
        'name',
        'src',
        'tree',
        'description',
        'price'
    ],

    components: { BreadcrumbBar }  
}
</script>

<style scoped>
.card {
    display: flex;
    flex-flow: column nowrap;
    justify-content: space-between;
    gap: 10px;
    width: 270px;
    height: 470px;
    padding: 20px;
    border: solid 1px #d3d3d3;
    box-shadow: 5px 5px 10px 0px #5c5c5c96;

    -webkit-box-shadow: 5px 5px 10px 0px #5c5c5c96;
    -moz-box-shadow: 5px 5px 10px 0px #5c5c5c96;
}

.card-description {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    /* Limita a 3 linhas */
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 0.9rem;
}

.card-img {
    width: 227px;
    height: 162px;
    display: flex;
    justify-content: center;
}

.card-price {
    font: 1.3rem Roboto, sans-serif;
    font-weight: 600;
    color: #2B2B3A;
}

.card-title {
    height: 40px;
}

.card-title h6 {
    color: #415163;
    font-family: Roboto, sans-serif;
}

img {
    max-width: 100%;
    /* Não ultrapassa a largura do container */
    max-height: 100%;
    /* Não ultrapassa a altura do container */
    width: auto;
    /* Mantém a proporção */
    height: auto;
    /* Mantém a proporção */
    object-fit: contain;
    /* Garante que a imagem se encaixe sem cortar */
}

.view-details {
    display: block;
}

.view-details button {
    width: 100%;
    border: solid 1px transparent;
    border-radius: 3px;
    color: #fff;
    background-color: #5286D9;
}
</style>