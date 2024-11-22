<template>
    <div class="d-flex flex-wrap gap-3">
        <div>
            <div class="row mb-4">
                <div class="col-sm-12 mb-2">
                    <div class="form-floating">
                        <input type="text" v-model="searchQuery" @input="onInputChange" placeholder="Produto"
                            class="form-control" />
                        <label for="stockProductId">Digite o nome do produto para pesquisar...</label>
                    </div>
                </div>
            </div>
            <div class="list">
                <ProductStrip v-for="(product, index) in products" :key="index"
                    :image="product.image?.storaged ? fetchFile(product.image.storaged) : fetchFile('nenhumaImagem.png')"
                    :id="product.id" :stock=product.stock :title="product.name" :description=product.description
                    :price=product.price :alt="product.name" />
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

<script>
import ProductStrip from '@/components/shop/ProductStrip.vue';
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'
import { debounce } from 'lodash';

export default {

    name: 'ProductsView',

    components: { ProductStrip },

    data() {
        return {
            products: [],
            product: {},
            searchQuery: '',
        };
    },

    mixins: [AbstractMixin, ProductMixin],

    mounted() {
        this.fetchProducts()
        console.log(this.products)
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