<template>
    <div class="card">
        <div class="card-img">
            <router-link :to="{ name: 'ProductView', params: { 'id': id } }">
                <img :src="src" :alt="name" />
            </router-link>
        </div>
        <div>{{ name }}</div>

    </div>
</template>

<script>

export default {
    name: 'ProductCard',

    props: [
        'id',
        'src',
        'name'
    ]
}
</script>

<style>
.card {
    width: 270px;
    height: 470px;
    padding: 10px;
    display: flex;
    flex-flow: column nowrap;
    gap: 20px;
    border: solid 1px #d3d3d3 !important
}

.card-img {
    width: 247px;
    height: 162px;
    display: flex;
    justify-content: center;
}

img {
    max-width: 200px;
}
</style>