<template>
    <div class="card">
        <div class="card-img">
            <router-link :to="{ name: 'ProductView', params: { 'id': id } }">
                <img :src="src" :alt="name" />
            </router-link>
        </div>
        <div class="card-title">{{ name }}</div>
        <div class="card-price">R$ {{ price }}</div>

    </div>
</template>

<script>

export default {
    name: 'ProductCard',

    props: [
        'id',
        'name',
        'src',
        'price'
    ]
}
</script>

<style scoped>

.card {    
    display: flex;
    flex-flow: column nowrap;
    gap: 10px;
    width: 270px;
    height: 470px;
    padding: 10px;
    border: solid 1px #d3d3d3
}

.card-img {
    width: 247px;
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
    color: #404040;
    font-family: Roboto, sans-serif;
    font-weight: 400;

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
</style>