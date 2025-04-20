<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ESTOQUE</span>
        </div>

        <div class="p-2">
            <div class="row">
                <div class="col-sm-12 col-lg-8 mb-2">
                    <h6>{{ `Editando... (Id. ${stock.id})` }}
                    </h6>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <input type="text" v-model="searchQuery" @input="onInputChange" placeholder="Produto *"
                                class="form-control" :class="errors.product_id ? 'is-invalid' : ''"
                                id="stockProductId" />
                            <label for="stockProductId">Produto *</label>
                            <div v-if="errors.product_id" id="stockProductIdFeedback"
                                class="invalid-feedback text-start">{{ errors.product_id }}
                            </div>
                            <div v-if="products.length > 0 && searchQuery.length >= 3" class="menu-products">
                                <ul>
                                    <li v-for="product in products" :key="product.id" @click="selectProduct(product)">
                                        {{ product.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.price ? 'is-invalid' : ''"
                                id="validationServerCodigo" aria-describedby="validationServerCodigoFeedback"
                                placeholder="Preço" v-model="stock.price">
                            <label for="validationServerCodigo">Preço (R$) *</label>
                            <div v-if="errors.price" id="validationServerCodigofeedback"
                                class="invalid-feedback text-start">
                                {{ errors.price[0] }}</div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                id="validationServerNome" aria-describedby="validationServerNomeFeedback"
                                placeholder="Nome" v-model="stock.quantity">
                            <label for="validationServerNome">quantidade *</label>
                            <div v-if="errors.name" id="validationServerNomeFeedback"
                                class="invalid-feedback text-start">{{ errors.name[0] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="obgField">* Campo obrigatório.</span>
                </div>
                <div class="card-footer text-end">
                    <router-link class="btn btn-gray me-2"
                        :to="{ name: 'getStock', params: { 'id': this.id } }">Cancelar</router-link>
                    <button class="btn btn-save" type="button"
                        @click="updateStock(stock.id)">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import StockMixin from '@/mixins/MovementMixin'
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'
import { debounce } from 'lodash';


export default {

    name: 'StockIndex',

    mixins: [AbstractMixin, StockMixin, ProductMixin],

    data() {
        return {
            id: this.$route.params.id,
            stock: {},
            products: {},
            searchQuery: '',
            loading: false
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getProducts(),
            this.getStock(this.id)
    },

    methods: {

        onInputChange: debounce(function () {
            if (this.searchQuery.length < 3) {
                this.products = {};
                return;
            }
            this.loading = true;
            this.getProducts(this.searchQuery);
            this.loading = false;
        }, 500),

        selectProduct(product) {
            this.searchQuery = product.name
            this.stock.product_id = product.id
            this.products = {}
        }
    }
}
</script>

<style>
</style>