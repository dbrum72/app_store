<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ESTOQUE</span>
        </div>

        <div class="p-2">
            <div class="box show">
                <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                    <span>Atenção</span>
                </div>
                <div v-if="stock" class="mb-3">
                    Confirma a exclusão da entrada de ID nº. {{ stock.id }} ?
                </div>
                <div class="text-end">
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getStock', params: { 'id': this.id }}">Cancelar</router-link>
                    <button type="button" class="btn btn-red" @click="(destroyStock(stock.id))">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import StockMixin from '@/mixins/StockMixin'
import AbstractMixin from '@/mixins/AbstractMixin'


export default {

    name: 'StockIndex',

    mixins: [AbstractMixin, StockMixin],

    data() {
        return {
            id: this.$route.params.id,
            stock: {},
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