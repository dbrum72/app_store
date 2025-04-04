<template>
        <nav class="nav-breadcrumb">
            <router-link v-for="(item, index) in treeArray" :key="index" :to="generatePath(index)"
                class="nav-breadcrumb-item">
                {{ item }}
            </router-link>
        </nav>
</template>

<script>
export default {
    name: 'BreadcrumbBar',

    props: [
        'tree'
    ],

    data() {
        return {
            url: process.env.VUE_APP_FRONTEND_URL + '/ecommerce?filter=tree&parameter=',
        }
    },

    computed: {
        treeArray() {
            return this.tree ? this.tree.split('/') : [];
        },
    },

    methods: {
        generatePath(index) {
            // Corrigido para gerar o caminho correto sem barras extras
            return this.url + this.treeArray.slice(index, index + 1).join(' / ');
        }
    }
};
</script>

<style scoped>
.nav-breadcrumb {
    display: flex;
}

.nav-breadcrumb-item {
    text-decoration: none;
    font-size: .8rem;
    color: #5c5c5c96
}


.nav-breadcrumb-item:not(:last-child)::after {
    content: " / ";
    color: gray;
}
</style>
