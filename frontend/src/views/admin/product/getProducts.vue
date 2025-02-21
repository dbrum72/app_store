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
                            <button type="button" class="btn btn-opcoes search-button" @click="getProducts(filter)"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div>
                        <router-link class="btn btn-sm btn-view" :to="{ name: 'newProduct' }"><i
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
                                <th scope="col">CÓDIGO/BARRAS</th>
                                <th scope="col">NOME</th>
                                <th scope="col">CATEGORIA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products" :key="index">
                                <td>{{ product.id }}</td>
                                <td>{{ product.barcode }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.category.tree }}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <router-link class="btn btn-sm btn-view" :to="{ name: 'getProduct', params: { 'id': product.id }}" title="Visualizar"><i
                                            class="fa-regular fa-folder-open"></i></router-link>
                                    </div>

                                </td>
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
        this.fetchCategories()
        this.getProducts()
    }
}
</script>

<style scoped>
</style>