<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ESTOQUE</span>
        </div>

        <div class="p-2">
            <template v-if="template === 'list'">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="form-floating flex-fill">
                        <input type="text" class="form-control" id="filterProduct" placeholder="Pesquisar name..."
                            v-model="filter">
                        <label for="filterProduct">Pesquisar produto...</label>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-opcoes search-button" @click="fetchStocks(filter)"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-view" title="Nova entrada"
                            @click="(stock = {}, this.SET_ERRORS([]), template = 'save')"><i
                                class="fa-solid fa-plus"></i>
                            Adicionar entrada</button>
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
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(stock, index) in stocks" :key="index">
                                <th>{{ stock.id }}</th>
                                <td>{{ formatDate(stock.created_at) }}</td>
                                <td>{{ stock.product.name }}</td>
                                <td class="text-end">{{ toCurrency(stock.price) }}</td>
                                <td class="text-end">{{ stock.quantity }}</td>
                                <td>
                                    <div class="d-flex justify-content-end m-2">
                                        <button class="btn btn-sm btn-view"
                                            @click="(fetchStock(stock.id), template = 'show')" title="Visualizar"><i
                                                class="fa-regular fa-folder-open"></i></button>
                                        <button class="btn btn-sm btn-edit"
                                            @click="(fetchStock(stock.id), template = 'save')" title="Editar"><i
                                                class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-delete"
                                            @click="(fetchStock(stock.id), template = 'delete')" title="Excluir"><i
                                                class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <span class="lenght0">Nenhum registro localizado.</span>
                </div>
            </template>

            <template v-if="template === 'save'">
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 mb-2">
                            <h6>{{ stock.id ? `Editando... (Id. ${stock.id})` : 'Nova entrada...' }}
                            </h6>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-floating">
                                    <input type="text" v-model="searchQuery" @input="onInputChange"
                                        placeholder="Produto *" class="form-control"
                                        :class="errors.product_id ? 'is-invalid' : ''" id="stockProductId" />
                                    <label for="stockProductId">Produto *</label>
                                    <div v-if="errors.product_id" id="stockProductIdFeedback"
                                        class="invalid-feedback text-start">{{ errors.product_id }}
                                    </div>
                                    <div v-if="products.length > 0 && searchQuery.length >= 3" class="menu-products">
                                        <ul>
                                            <li v-for="product in products" :key="product.id"
                                                @click="selectProduct(product)">
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
                            <button type="button" class="btn btn-cancel me-2"
                                @click="(resetStockView(), template = 'list')">Cancelar</button>
                            <button class="btn btn-save" type="button"
                                @click="saveStock(stock.id ? stock.id : null)">Salvar</button>
                        </div>
                    </div>
                </div>
            </template>

            <template v-if="template === 'delete'">
                <div class="box show">
                    <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                        <span>Atenção</span>
                    </div>
                    <div v-if="stock" class="mb-3">
                        Confirma a exclusão da entrada de ID nº. {{ stock.id }} ?
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-cancel me-2" @click="(resetStockView(), template = 'list')">Cancelar</button>
                        <button type="button" class="btn btn-delete" @click="(destroyStock(stock.id))">Excluir</button>
                    </div>
                </div>
            </template>

            <template v-if="template === 'show'">
                <div class="">
                    <div class="subArea">
                        <div class="title-sub-area">
                            <div>
                                <span>Informações</span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-view" @click="(template = 'list')"
                                    title="Lista de produtos"><i class="fa-solid fa-list"></i></button>
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Produto
                            </div>
                            <div class="data">
                                {{ this.stock.product?.name }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Preço
                            </div>
                            <div class="data">
                                {{ toCurrency(this.stock.price) }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Quantidade
                            </div>
                            <div class="data">
                                {{ this.stock.quantity }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                ID
                            </div>
                            <div class="data">
                                {{ this.stock.id ? this.stock.id : '---' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Criado em
                            </div>
                            <div class="data">
                                {{ this.stock.created_at ? formatDate(this.stock.created_at) : '' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Atualizado em
                            </div>
                            <div class="data">
                                {{ this.stock.updated_at ? formatDate(this.stock.updated_at) : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>
</template>

<script>
import { mapState } from "vuex"
import StockMixin from '@/mixins/StockMixin'
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'
import { debounce } from 'lodash';


export default {

    name: 'StockIndex',

    mixins: [AbstractMixin, StockMixin, ProductMixin],

    data() {
        return {
            template: 'list',
            stocks: [],
            stock: {},
            searchQuery: '',
            products: [],
            filter: '',
            loading: false
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchStocks()
    },

    methods: {

        onInputChange: debounce(function () {
            if (this.searchQuery.length < 3) {
                this.products = [];
                return;
            }
            this.loading = true;
            this.fetchProducts(this.searchQuery);
            this.loading = false;
        }, 500),

        selectProduct(product) {
            this.searchQuery = product.name
            this.stock.product_id = product.id
            this.products = []
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