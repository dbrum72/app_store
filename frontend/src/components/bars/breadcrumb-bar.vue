<template>
    <nav class="nav-breadcrumb">
        <router-link v-for="(item, index) in treeArray" :key="index" :to="generatePath(index,item)"
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

    computed: {
        treeArray() {
            return this.tree ? this.tree.split('/') : [];
        },
    },

    methods: {
        generatePath(index,item) {
            // Corrigido para gerar o caminho correto sem barras extras
            return `${process.env.VUE_APP_FRONTEND_URL}/ecommerce?filter&extendedFilter=categorY,${item}&parameter=tree`;
        }
    }
};
</script>

<style scoped>
.nav-breadcrumb {
    display: flex;
    gap: 3px;
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
