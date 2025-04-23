<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">PRODUTO</span>
        </div>

        <div class="p-2">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div class="form-floating flex-fill">
                    <input type="text" class="form-control" id="filterProduct" placeholder="Pesquisar..."
                        v-model="filter">
                    <label for="filterProduct">Pesquisar...</label>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-opcoes search-button"
                            @click="getProducts(filter, null, 'name', 'name ASC')"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div>
                    <router-link class="btn btn-sm btn-green" :to="{ name: 'newProduct' }"><i
                            class="fa-solid fa-plus"></i> Adicionar produto</router-link>
                </div>
            </div>
            <div class="mb-2">
                <h6 class="card-header">Lista de produtos...</h6>
            </div>

            <div class="mb-2" v-if="(products && products.length > 0)">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col"></th>
                            <th scope="col">PRODUTO</th>
                            <th scope="col">CATEGORIA</th>
                            <th scope="col">CÓDIGO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in products" :key="index" @click="navigateTo(product.id)">
                            <td>{{ product.id }}</td>
                            <td><img :src="getFile(product.files?.[0]?.storaged ?? 'nenhumaImagem.png')"></td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.category.tree }}</td>
                            <td>{{ product.barcode }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <span class="lenght0">Nenhum registro localizado.</span>
            </div>

        </div>
    </div>
</template>

<script>

import { mapState } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';
import CategoryMixin from '@/mixins/CategoryMixin';

export default {

    name: 'ProductIndex',

    mixins: [AbstractMixin, ProductMixin, CategoryMixin],

    data() {
        return {
            products: {},
            categories: {},
            filter: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getCategories(null, null, null, null)
        this.getProducts(null, null, null, 'name ASC')
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: "getProduct", params: { id } });
        }
    }
}
</script>

<style scoped>
img {
    width: 40px;
    height: 40px;
}
</style>