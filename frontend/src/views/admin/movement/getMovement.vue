<template>
    <div :class="{ 'blurred': loader.active }">

        <div class="d-flex areaHeader">
            <span class="font12rW600TuCg pe-2">ESTOQUE</span>
            <router-link class="btn btn-sm btn-gray" :to="{ name: 'getStocks' }" title="Lista de entradas"><i
                    class="fa-solid fa-list"></i></router-link>
        </div>

        <div class="p-2">
            <div class="subArea">
                <div class="title-sub-area">
                    <div>
                        <span>Informações</span>
                    </div>
                    <div class="d-flex">
                        <router-link class="btn btn-sm btn-blue" :to="{ name: 'editStock', params: { id: stock.id }}" title="Editar"><i
                            class="fa-solid fa-pencil"></i></router-link>
                        <router-link class="btn btn-sm btn-red" :to="{ name: 'deleteStock', params: { id: stock.id}}" title="Excluir"><i
                            class="fa-regular fa-trash-can"></i></router-link>
                    </div>
                </div>
                <div class="dados">
                    <div class="tupla">
                        <div class="field">
                            ID
                        </div>
                        <div class="data">
                            {{ this.stock.id }}
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
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import StockMixin from '@/mixins/MovementMixin'
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'


export default {

    name: 'StockIndex',

    mixins: [AbstractMixin, StockMixin, ProductMixin],

    data() {
        return {
            id: this.$route.params.id,
            stock: {},
            products: {},
            loading: false
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getStock(this.id)
    }
}
</script>

<style></style>