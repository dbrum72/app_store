<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CATEGORIA</span>
        </div>

        <div class="p-2">
            <div class="box show">
                <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                    <span>Atenção</span>
                </div>
                <div style="margin: 10px;">
                    Confirma a exclusão da categoria de ID nº. "{{ category.id }}" ?
                </div>
                <div class="text-end">
                    <router-link class="btn btn-cancel me-2" :to="{ name: 'getCategory', params: { 'id': this.id }}">Cancelar</router-link>
                    <button type="button" class="btn btn-delete"
                        @click="(destroyCategory(category.id))">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin'
import CategoryMixin from '@/mixins/CategoryMixin'

export default {

    name: 'DeleteCategory',

    mixins: [AbstractMixin, CategoryMixin],

    data() {
        return {
            id: this.$route.params.id,
            category: {},
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchCategory(this.id)
    }
}
</script>

<style></style>