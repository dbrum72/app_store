<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">PRODUTO</span>
        </div>

        <div class="p-2">
            <div class="box show">
                <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                    <span>Atenção</span>
                </div>
                <div style="margin: 10px;">
                    Confirma a exclusão do produto de ID nº. "{{ this.id }}" ?
                </div>
                <div class="text-end">
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getProduct', params: { 'id': this.id }}">Cancelar</router-link>
                    <button type="button" class="btn btn-red" @click="(destroyProduct(this.id))">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapState } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';

export default {

    name: 'DeleteProduct',

    mixins: [AbstractMixin, ProductMixin],

    data() {
        return {
            id: this.$route.params.id
        };
    },

    computed: mapState(['errors', 'loader']),
}
</script>

<style scoped>

</style>