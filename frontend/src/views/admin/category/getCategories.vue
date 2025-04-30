<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CATEGORIAS</span>
        </div>

        <div class="p-2">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div class="position-relative">
                    <input type="text" class="form-control pe-5" id="searchCategory" placeholder="Pesquisar categoria..."
                        v-model="searchQuery">
                    <button class="position-absolute top-50 end-0 translate-middle-y me-3 search-button"
                        @click="getCategories(searchQuery, 'name', 'name ASC')">
                        <i class="fa-solid fa-magnifying-glass"></i></button>
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
            searchQuery: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getCategories(null, null, 'name ASC')
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: 'getCategory', params: { 'id': id}})
        }
    }
}
</script>

<style></style>