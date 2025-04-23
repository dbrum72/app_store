<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">PRODUTO</span>
        </div>

        <div class="p-2">
            <div class="row">
                <div class="col-sm-12 col-lg-8 mb-2">
                    <h6>Novo produto...
                    </h6>
                </div>
                <div class="col-sm-12 col-lg-4 mb-2" v-if="product.id">
                    <div class="form-floating">
                        <div class="form-check text-start">
                            <input class="form-check-input" type="checkbox" false-value="0" true-value="1"
                                id="flexCheckDefault" v-model="product.descontinuado">
                            <label class="form-check-label" for="flexCheckDefault">
                                descontinuado
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <div class="form-floating">
                            <select class="form-select" :class="errors.category_id ? 'is-invalid' : ''"
                                id="validationServerCategory" aria-describedby="validationServerCategoryFeedback"
                                v-model="product.category_id">
                                <option disabled selected>Selecione ...</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id">{{
                                    category.tree }}</option>
                            </select>
                            <label for="validationServerCategory">Categoria</label>
                            <div v-if="errors.category_id" id="validationServerCategoryFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.category_id[0] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.barcode ? 'is-invalid' : ''"
                                id="validationServerCodigo" aria-describedby="validationServerCodigoFeedback"
                                placeholder="Codigo" v-model="product.barcode">
                            <label for="validationServerCodigo">Codigo</label>
                            <div v-if="errors.barcode" id="validationServerCodigofeedback"
                                class="invalid-feedback text-start">
                                {{ errors.barcode[0] }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                id="validationServerNome" aria-describedby="validationServerNomeFeedback"
                                placeholder="Nome *" v-model="product.name">
                            <label for="validationServerNome">Nome *</label>
                            <div v-if="errors.name" id="validationServerNomeFeedback"
                                class="invalid-feedback text-start">{{ errors.name[0] }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.price ? 'is-invalid' : ''"
                                id="validationServerPrice" aria-describedby="validationServerPriceFeedback"
                                placeholder="Preço *" v-model="product.price">
                            <label for="validationServerPrice">Preço *</label>
                            <div v-if="errors.price" id="validationServerPriceFeedback"
                                class="invalid-feedback text-start">{{ errors.price[0] }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <textarea class="form-control" :class="errors.description ? 'is-invalid' : ''"
                                id="validationServerDescricao" aria-describedby="validationServerDescricaoFeedback"
                                v-model="product.description"></textarea>
                            <label for="validationServerDescricao">Descrição *</label>
                            <div v-if="errors.description" id="validationServerDescricaoFeedback"
                                class="invalid-feedback text-start">{{ errors.description[0] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="obgField">* Campo obrigatório.</span>
                </div>
                <div class="card-footer text-end">
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getProducts' }">Cancelar</router-link>
                    <button class="btn btn-save" type="button" @click="storeProduct()">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapState } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';
import CategoryMixin from '@/mixins/CategoryMixin';

export default {

    name: 'NewProduct',

    mixins: [AbstractMixin, ProductMixin, CategoryMixin],

    data() {
        return {
            product: {},
            categories: {},
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getCategories(null, null, 'name ASC')
        this.getProducts()
    }
}
</script>

<style scoped></style>