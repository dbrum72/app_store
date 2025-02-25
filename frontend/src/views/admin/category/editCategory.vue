<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CATEGORIA</span>
        </div>

        <div class="p-2">

            
                <div>
                    <h6>{{ `Editando... (Id. ${category.id})` }}
                    </h6>
                    <div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class='form-floating'>
                                    <select class="form-select" :class="errors.parent_id ? 'is-invalid' : ''"
                                        id="validationServerCategoryPaiId"
                                        aria-label="validationServerCategoryPaiIdFeedback" v-model="category.parent_id">
                                        <option disabled selected>Selecione...</option>
                                        <option v-for="(category, index) in categories" :key="index"
                                            :value="category.id">
                                            {{ category.tree }}</option>
                                    </select>
                                    <label for="validationServerCategoryPaiId">Categoria pai</label>
                                    <div v-if="errors.parent_id" id="validationServerCategoryPaiIdFeedback"
                                        class="invalid-feedback text-start">{{
                                            errors.parent_id[0] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div class='form-floating'>
                                    <input type="name" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                        id="validationServerCategoryNome"
                                        aria-describedby="validationServerCategoryNomeFeedback" placeholder="Nome"
                                        v-model="category.name" />
                                    <label for="validationServerLoginName">Nome</label>
                                    <div v-if="errors.name" id="validationServerCategoryNomeFeedback"
                                        class="invalid-feedback text-start">{{
                                            errors.name[0] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <router-link class="btn btn-gray me-2" :to="{ name: 'getCategory', params: { 'id': this.id }}">Cancelar</router-link>
                            <button type="button" class="btn btn-save"
                                @click="updateCategory(category.id)">Salvar</button>
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
            categories: {}
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchCategories()
        this.fetchCategory(this.id)
    }
}
</script>

<style></style>