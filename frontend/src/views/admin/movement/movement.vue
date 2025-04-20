<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ESTOQUE</span>
        </div>

        <div class="p-2">
            <div class="row">
                <div class="col-sm-12 col-lg-8 mb-2">
                    <h6>Novo fluxo...
                    </h6>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <div class="form-floating">
                            <select class="form-select" :class="errors.flow_id ? 'is-invalid' : ''"
                                id="validationServerFlowId" aria-describedby="validationServerFlowIdFeedback"
                                v-model="stock.flow_id" @change="getFlowTypes()">
                                <option disabled selected>Selecione ...</option>
                                <option v-for="flow in flows" :key="flow.id" :value="flow.id">{{
                                    flow.flow }}</option>
                            </select>
                            <label for="validationServerFlowId">Fluxo *</label>
                            <div v-if="errors.flow_id" id="validationServerFlowIdFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.flow_id[0] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <div class="form-floating">
                            <select class="form-select" :class="errors.flow_type_id ? 'is-invalid' : ''"
                                id="validationServerFlowTypeId" aria-describedby="validationServerFlowTypeIdFeedback"
                                v-model="stock.flow_type_id" :disabled="flowTypes.length === 0">
                                <option disabled selected>Selecione ...</option>
                                <option v-for="flowType in flowTypes" :key="flowType.id" :value="flowType.id">{{
                                    flowType.type }}</option>
                            </select>
                            <label for="validationServerFlowTypeId">Tipo *</label>
                            <div v-if="errors.flow_type_id" id="validationServerFlowTypeIdFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.flow_type_id[0] }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <input type="text" v-model="searchQuery" @input="onInputChange" placeholder="Produto *"
                                class="form-control" :class="errors.product_id ? 'is-invalid' : ''"
                                id="stockProductId" />
                            <label for="stockProductId">Produto *</label>
                            <div v-if="errors.product_id" id="stockProductIdFeedback"
                                class="invalid-feedback text-start">{{ errors.product_id[0] }}
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
                                id="validationServerPrice" aria-describedby="validationServerPriceFeedback"
                                placeholder="Preço" v-model="stock.price">
                            <label for="validationServerPrice">Preço (R$) *</label>
                            <div v-if="errors.price" id="validationServerPricefeedback"
                                class="invalid-feedback text-start">
                                {{ errors.price[0] }}</div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.quantity ? 'is-invalid' : ''"
                                id="validationServerQuantity" aria-describedby="validationServerQuantityFeedback"
                                placeholder="Nome" v-model="stock.quantity">
                            <label for="validationServerQuantity">Quantidade *</label>
                            <div v-if="errors.quantity" id="validationServerQuantityFeedback"
                                class="invalid-feedback text-start">{{ errors.quantity[0] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="obgField">* Campo obrigatório.</span>
                </div>
                <div class="card-footer text-end">
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getStocks' }">Cancelar</router-link>
                    <button class="btn btn-save" type="button" @click="storeStock()">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import StockMixin from '@/mixins/MovementMixin'
import StockFlowMixin from '@/mixins/StockFlowMixin'
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'
import { debounce } from 'lodash';


export default {

    name: 'StockIndex',

    mixins: [AbstractMixin, StockMixin, StockFlowMixin, ProductMixin],

    data() {
        return {
            stock: {},
            products: {},
            flows: {},
            flowTypes: '',
            searchQuery: '',
            filter: '',
            loading: false
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getFlows()
        this.getStocks()
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