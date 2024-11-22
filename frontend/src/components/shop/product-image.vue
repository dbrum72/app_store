<template>
    <div class="view">
        <img :src="src" :alt="alt">
    </div>
</template>

<script>
export default {

    name: 'ProductImage',

    props: [
        'src',
        'alt'
    ]
}
</script>

<style scoped>

img {
    width: 12.4rem;
    height: 8rem;
    background-color: #fff;
}
.view {
    padding: 10px;
    background-color: #fff !important;
}
</style>