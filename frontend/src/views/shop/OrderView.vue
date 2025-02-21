<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">pedidos</span>
        </div>

        <div class="p-2">
            <template v-if="template === 'list'">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="form-floating flex-fill">
                        <input type="text" class="form-control" id="filterCategory" placeholder="Pesquisar name..."
                            v-model="filter">
                        <label for="filterCategory">Pesquisar nome...</label>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-opcoes search-button"
                                @click="fetchCategories(filter)"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-view" title="Adicionar category"
                            @click="(category = {}, this.SET_ERRORS([]), template = 'save')"><i
                                class="fa-solid fa-plus"></i> Novo Pedido</button>
                    </div>
                </div>
                <div class="mb-2">
                    <h6 class="card-header">Lista de pedidos...</h6>
                </div>


                <div class="mb-2" v-if="(orders && orders.length > 0)">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOME</th>
                                <th scope="col">ÁRVORE</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in categories" :key="index">
                                <td>{{ category.id }}</td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.tree }}</td>
                                <td>
                                    <div class="d-flex justify-content-end m-2">
                                        <button class="btn btn-sm btn-view"
                                            @click="(fetchCategory(category.id), template = 'show')"
                                            title="Visualizar"><i class="fa-regular fa-folder-open"></i></button>
                                        <button class="btn btn-sm btn-edit"
                                            @click="(fetchCategory(category.id), template = 'save')" title="Editar"><i
                                                class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-delete"
                                            @click="(fetchCategory(category.id), template = 'delete')"
                                            title="Excluir"><i class="fa-regular fa-trash-can"></i></button>

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
                <div class="d-flex flex-wrap gap-3">
                    <div>
                        <div class="row mb-4">
                            <div class="col-sm-12 mb-2">
                                <div class="form-floating">
                                    <input type="text" v-model="searchQuery" @input="onInputChange"
                                        placeholder="Produto" class="form-control" />
                                    <label for="stockProductId">Digite o nome do produto para pesquisar...</label>
                                </div>
                            </div>
                        </div>
                        <div class="list">
                            <ProductStrip v-for="(product, index) in products" :key="index"
                                :image="product.image?.storaged ? fetchFile(product.image.storaged) : fetchFile('nenhumaImagem.png')"
                                :id="product.id" :stock=product.stock :title="product.name"
                                :description=product.description :price=product.price :alt="product.name" />
                        </div>
                    </div>
                    <div class="orders p-3">
                        <span>ordem de venda nº. {{ 1 }}</span>
                        <div class="resume">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Qtd.</th>
                                    <th>Preço</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>{{ product_id }}</td>
                                    <td>{{ product_name }}</td>
                                    <td>{{ quantity }}</td>
                                    <td>{{ toCurrency(price) }}</td>
                                    <td>{{ toCurrency(quantity * price) }}</td>
                                    <td><i class="fa-solid fa-cart-arrow-down btn-remove" title="Retirar do carrinho"
                                            @click="FILTER_CART(id)"></i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>



</template>

<script>
import { mapState } from "vuex"
import ProductStrip from '@/components/shop/ProductStrip.vue';
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'
import { debounce } from 'lodash';

export default {

    name: 'ProductsView',

    components: { ProductStrip },

    data() {
        return {
            template: 'list',
            products: [],
            product: {},
            searchQuery: '',
        };
    },

    mixins: [AbstractMixin, ProductMixin],

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getProducts()
        console.log(this.products)
    },

    methods: {

        onInputChange: debounce(function () {
            if (this.searchQuery.length < 3) {
                this.products = [];
                return;
            }
            this.loading = true;
            this.getProducts(this.searchQuery);
            this.loading = false;
        }, 500),

        selectProduct(product) {
            this.searchQuery = product.name
            this.products = []
        }
    }
};
</script>
<style scoped>
.btn-remove {
    margin-left: .5rem;
    font-size: 1rem;
    cursor: pointer;
    color: red;
}

.btn-remove:hover {
    font-size: 1.1rem;
}

.list {
    display: flex;
    flex-flow: column nowrap;
    justify-content: space-between;
}

.orders {
    display: flex;
    flex-flow: column nowrap;
    margin-bottom: 20px;
    padding: 8px;
    background-color: #2F465F;
}

.orders>span {
    margin-bottom: 20px;
    font: 500 1.5rem Roboto, sans-serif;
    text-transform: uppercase;
    color: #989898;
    background-color: #2F465F;
}

.resume {
    background-color: #dcdfdf;
}
</style>