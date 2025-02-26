<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CATEGORIAS</span>
        </div>

        <div class="p-2">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div class="form-floating flex-fill">
                    <input type="text" class="form-control" id="filterCategory" placeholder="Pesquisar name..."
                        v-model="filter">
                    <label for="filterCategory">Pesquisar nome...</label>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-opcoes search-button" @click="getCategories(filter)"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div>
                    <router-link class="btn btn-sm btn-green" :to="{ name: 'newCategory' }"><i
                            class="fa-solid fa-plus"></i> Adicionar categoria</router-link>
                </div>
            </div>
            <div class="mb-2">
                <h6 class="card-header">Lista de categorias...</h6>
            </div>


            <div class="mb-2" v-if="(categories && categories.length > 0)">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">ÁRVORE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in categories" :key="index" @click="navigateTo(category.id)">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.tree }}</td>
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
import AbstractMixin from '@/mixins/AbstractMixin'
import CategoryMixin from '@/mixins/CategoryMixin'

export default {

    name: 'GetCategories',

    mixins: [AbstractMixin, CategoryMixin],

    data() {
        return {
            categories: {},
            filter: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getCategories()
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: 'getCategory', params: { 'id': id}})
        }
    }
}
</script>

<style></style>