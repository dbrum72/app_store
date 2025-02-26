<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ESTOQUE</span>
        </div>

        <div class="p-2">

            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div class="form-floating flex-fill">
                    <input type="text" class="form-control" id="filterProduct" placeholder="Pesquisar name..."
                        v-model="subFilter">
                    <label for="filterProduct">Pesquisar produto...</label>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-opcoes search-button" @click="getStocks(subFilter)"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div>
                    <router-link class="btn btn-sm btn-green" :to="{ name: 'newStock' }" title="Nova entrada"><i
                            class="fa-solid fa-plus"></i>
                        Adicionar entrada</router-link>
                </div>
            </div>

            <div class="mb-2">
                <h6 class="card-header">Lista de entradas...</h6>
            </div>

            <div class="mb-2" v-if="(stocks && stocks.length > 0)">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">DATA</th>
                            <th scope="col">PRODUTO</th>
                            <th scope="col">PREÇO</th>
                            <th scope="col">QTD.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(stock, index) in stocks" :key="index" @click="navigateTo(stock.id)">
                            <th>{{ stock.id }}</th>
                            <td>{{ formatDate(stock.created_at) }}</td>
                            <td>{{ stock.product.name }}</td>
                            <td class="text-end">{{ toCurrency(stock.price) }}</td>
                            <td class="text-end">{{ stock.quantity }}</td>
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
import StockMixin from '@/mixins/StockMixin'
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'


export default {

    name: 'StockIndex',

    mixins: [AbstractMixin, StockMixin, ProductMixin],

    data() {
        return {
            stocks: {},
            searchQuery: '',
            products: {},
            subFilter: '',
            loading: false
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getStocks()
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: 'getStock', params: { 'id': id}})
        }
    }
}
</script>

<style>
.menu-products {
    position: absolute;
    top: 100%;
    /* Faz o menu aparecer logo abaixo do input */
    left: 0;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-top: none;
    background-color: #f0f0f0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 100;
}

.menu-products ul {
    padding-left: 0;
    margin: 0;
}

.menu-products li {
    list-style-type: none;
    padding: 10px;
    cursor: pointer;
    font-size: 14px;
}

.menu-products li:hover {
    background-color: #e0f8e6;
}
</style>