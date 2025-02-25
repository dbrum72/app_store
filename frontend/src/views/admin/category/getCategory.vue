<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="d-flex areaHeader">
            <span class="font12rW600TuCg pe-2">CATEGORIA</span>
            <router-link class="btn btn-sm btn-gray" :to="{ name: 'getCategories' }"><i class="fa-solid fa-list"
                    title="Lista de categorias"></i></router-link>
        </div>
        <div class="subArea mb-5">
            <div class="d-flex justify-content-between m-2 title-sub-area">
                <div><span>Informações</span></div>
                <div class="d-flex justify-content-end">
                    <router-link class="btn btn-sm btn-blue"
                        :to="{ name: 'editCategory', params: { 'id': category.id } }"><i class="fa-solid fa-pencil"
                            title="Editar"></i></router-link>
                    <router-link class="btn btn-sm btn-red"
                        :to="{ name: 'deleteCategory', params: { 'id': category.id } }"><i
                            class="fa-regular fa-trash-can" title="Excluir"></i></router-link>
                </div>
            </div>
            <div class="dados">
                <div class="tupla">
                    <div class="field">
                        ID
                    </div>
                    <div class="data">
                        {{ category.id }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Nome
                    </div>
                    <div class="data">
                        {{ category.name }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Categoria pai
                    </div>
                    <div class="data">
                        {{ category.tree }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Criado em
                    </div>
                    <div class="data">
                        {{ category.created_at ? formatDate(this.category.created_at) : '' }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Atualizado em
                    </div>
                    <div class="data">
                        {{ category.updated_at ? formatDate(this.category.updated_at) : '' }}
                    </div>
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

    name: 'CategoryView',

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