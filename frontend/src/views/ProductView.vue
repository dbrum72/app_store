<template>
    <div class="content">
        <div id="area">

            <template v-if="template === 'list'">
                <div class="d-flex justify-content-between areaHeader">
                    <div class="text-start">
                        <span>PRODUTOS</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-headArea" title="Novo produto"
                            @click="(product = {}, template = 'save')"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="searchProduct" placeholder="Pesquisar name..."
                            v-model="search">
                        <label for="searchProduct">Pesquisar...</label>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-opcoes search-button" @click="fetchProducts()"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </div>

                <div class="mb-2" v-if="(products.length > 0)">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">CÓDIGO</th>
                                <th scope="col">NOME</th>
                                <th scope="col">CATEGORIA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products" :key="index">
                                <td>{{ product.barcode }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.category.name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-opcoes me-2"
                                        @click="(this.template = 'show', this.loadProduct(product.id))"
                                        title="Visualizar"><i
                                            class="fa-solid fa-arrow-up-right-from-square"></i></button>

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
                <div class="d-flex justify-content-between areaHeader">
                    <div class="text-start">
                        <span>PRODUTO</span>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{{ product.id ? `Editando... (Id. ${product.id})` : 'Novo product...' }}
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-2">
                                <div class="form-floating">
                                    <select class="form-select" :class="errors.category_id ? 'is-invalid' : ''"
                                        id="validationServerCategory"
                                        aria-describedby="validationServerCategoryFeedback"
                                        v-model="product.category_id">
                                        <option disabled selected>Selecione ...</option>
                                        <option v-for="(category, index) in Categories" :key="index"
                                            :value="category.id">{{ category.name }}</option>
                                    </select>
                                    <label for="validationServerCategory">Category</label>
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
                                        placeholder="Nome" v-model="product.name">
                                    <label for="validationServerNome">Nome *</label>
                                    <div v-if="errors.name" id="validationServerNomeFeedback"
                                        class="invalid-feedback text-start">{{ errors.name[0] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="form-floating">
                                    <textarea class="form-control" :class="errors.description ? 'is-invalid' : ''"
                                        id="validationServerDescricao"
                                        aria-describedby="validationServerDescricaoFeedback"
                                        v-model="product.description"></textarea>
                                    <label for="validationServerDescricao">Descrição *</label>
                                    <div v-if="errors.description" id="validationServerDescricaoFeedback"
                                        class="invalid-feedback text-start">{{ errors.description[0] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-lg-4 mb-2">
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
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-cancel me-2"
                            @click="(product.id ? (this.template = 'show', this.loadProduct(product.id)) : (this.template = 'list', this.product = {}), this.loadProducts())">Cancelar</button>
                        <button class="btn btn-acao" type="button"
                            @click="saveProduct(product.id ? product.id : null)">Salvar</button>
                    </div>
                </div>
                <div>
                    <span class="obgField">* Campo obrigatório.</span>
                </div>
            </template>

            <template v-if="template === 'show'">
                <div class="d-flex justify-content-between areaHeader">
                    <div class="text-start">
                        <span>PRODUTO</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-headArea me-2" title="Lista de products"
                            @click="(fetchProducts(), template = 'list')"><i
                                class="fa-solid fa-users"></i></button>
                    </div>
                </div>
                <div class="">
                    <div class="subArea">
                        <div class="title-sub-area">
                            <span>Informações</span>
                            <div class="d-flex justify-content-end m-2">
                                <button class="btn btn-sm btn-headSubArea"
                                    @click="(this.template = 'save', this.loadProduct(product.id))" title="Editar"><i
                                        class="fa-solid fa-user-pen"></i></button>
                                <button class="btn btn-sm btn-delete"
                                    @click="(this.template = 'excluir-product', this.loadProduct(product.id))"
                                    title="Excluir"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Código
                            </div>
                            <div class="data">
                                {{ this.product.barcode ? this.product.barcode : '---' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Category
                            </div>
                            <div class="data">
                                {{ this.product.category ? this.product.category['name'] : '---' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Nome
                            </div>
                            <div class="data">
                                {{ this.product.name }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Descrição
                            </div>
                            <div class="data">
                                {{ this.product.description }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Criado em
                            </div>
                            <div class="data">
                                {{ this.product.created_at ? formatDate(this.product.created_at) : '' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Atualizado em
                            </div>
                            <div class="data">
                                {{ this.product.updated_at ? formatDate(this.product.updated_at) : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template v-if="template === 'excluir-product'">
                <div class="d-flex justify-content-between areaHeader">
                    <div class="text-start">
                        <span>PRODUTO</span>
                    </div>
                </div>
                <div class="box show">
                    <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                        <span>Atenção</span>
                    </div>
                    <div style="margin: 10px;">
                        Confirma a exclusão do(a) product "{{ product.name }}" ?
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-cancel"
                            @click="(template = 'show', fetchProduct(product.id))">Cancelar</button>
                        <button type="button" class="btn btn-delete"
                            @click="deleteProduct(product.id)">Excluir</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';

export default {

    name: 'ProductView',

    mixins: [ AbstractMixin, ProductMixin ],

    data() {
        return {
            template: 'list',
            products: [],
            product: {},
            categories: [],
            search: '',
            errors: []
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.loadCategories()
        this.fetchProducts()
    }
};
</script>