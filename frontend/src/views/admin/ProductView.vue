<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="fontSr12w600Cg">PRODUTO</span>
        </div>

        <div class="p-2">
            <template v-if="template === 'list'">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="form-floating flex-fill">
                        <input type="text" class="form-control" id="filterProduct" placeholder="Pesquisar..."
                            v-model="filter">
                        <label for="filterProduct">Pesquisar...</label>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-opcoes search-button" @click="fetchProducts(filter)"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-view" title="Novo produto"
                            @click="(product = {}, template = 'save')"><i class="fa-solid fa-plus"></i>
                            Adicionar produto</button>
                    </div>
                </div>
                <div class="mb-2">
                    <h6 class="card-header">Lista de produtos...</h6>
                </div>

                <div class="mb-2" v-if="(products && products.length > 0)">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CÓDIGO/BARRAS</th>
                                <th scope="col">NOME</th>
                                <th scope="col">CATEGORIA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products" :key="index">
                                <td>{{ product.id }}</td>
                                <td>{{ product.barcode }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.category.tree }}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-view"
                                            @click="(fetchProduct(product.id), template = 'show')" title="Visualizar"><i
                                                class="fa-regular fa-folder-open"></i></button>
                                        <button class="btn btn-sm btn-edit"
                                            @click="(fetchProduct(product.id), template = 'save')" title="Editar"><i
                                                class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-delete"
                                            @click="(fetchProduct(product.id), template = 'delete')" title="Excluir"><i
                                                class="fa-regular fa-trash-can"></i></button>
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
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 mb-2">
                            <h6>{{ product.id ? `Editando... (Id. ${product.id})` : 'Novo produto...' }}
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
                        <div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-2">
                                <div class="form-floating">
                                    <select class="form-select" :class="errors.category_id ? 'is-invalid' : ''"
                                        id="validationServerCategory"
                                        aria-describedby="validationServerCategoryFeedback"
                                        v-model="product.category_id">
                                        <option disabled selected>Selecione ...</option>
                                        <option v-for="(category, index) in categories" :key="index"
                                            :value="category.id">{{ category.tree }}</option>
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
                                        id="validationServerDescricao"
                                        aria-describedby="validationServerDescricaoFeedback"
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
                            <button type="button" class="btn btn-cancel me-2"
                                @click="(template = 'list')">Cancelar</button>
                            <button class="btn btn-save" type="button"
                                @click="saveProduct(product.id ? product.id : null)">Salvar</button>
                        </div>
                    </div>
                </div>
            </template>

            <template v-if="template === 'delete'">
                <div class="box show">
                    <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                        <span>Atenção</span>
                    </div>
                    <div style="margin: 10px;">
                        Confirma a exclusão do produto de ID nº. "{{ product.id }}" ?
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-cancel me-2" @click="(template = 'list')">Cancelar</button>
                        <button type="button" class="btn btn-delete"
                            @click="(destroyProduct(product.id))">Excluir</button>
                    </div>
                </div>
            </template>

            <template v-if="template === 'show'">
                <div class="">
                    <div class="subArea">
                        <div class="title-sub-area">
                            <span>Informações</span>
                            <div class="d-flex justify-content-end m-2">
                                <button class="btn btn-sm btn-view" @click="(template = 'list')"
                                    title="Lista de produtos"><i class="fa-solid fa-list"></i></button>
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
                                Preço
                            </div>
                            <div class="data">
                                {{ toCurrency(this.product.price) }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Categoria
                            </div>
                            <div class="data">
                                {{ this.product.category ? this.product.category['tree'] : '---' }}
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
                                ID
                            </div>
                            <div class="data">
                                {{ this.product.id ? this.product.id : '---' }}
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

                    <div class="subArea">
                        <div class="title-sub-area">
                            <span>Estoque</span>
                            <div class="d-flex justify-content-end m-2">
                                <router-link class="btn btn-sm btn-view" type="button" :to="{ name: 'Stock' }"><i
                                        class="fa-solid fa-share"></i>
                                    Ir para estoques</router-link>
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field" :style="!this.product.stock ? 'color:red' : ''">
                                {{ this.product.stock ? 'Disponível' : 'Indisponível' }}
                            </div>
                            <div class="data">
                                {{ this.product.stock ? this.product.stock : '' }}
                            </div>
                        </div>
                    </div>

                    <div class="subArea" v-if="product.id">
                        <div class="title-sub-area">
                            <span>Lista de arquivos</span>
                        </div>
                    </div>
                    <div class="d-flex m-2">
                        <div class="d-flex" v-if="(product.files && product.files.length > 0)">
                            <div class="me-2" v-for="(file, index) in product.files" :key="index">
                                <div class="position-relative me-3 mb-3">
                                    <img :src="fetchFile(file.storaged)" width="100px" height="100px" :title="file.name"
                                        :alt="file.name">
                                    <button class="btn-trash btn-delete" title="Excluir"
                                        @click="destroyFile(file.id)"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="addFile" data-bs-toggle="modal" data-bs-target="#addFile">
                                <div><i class="fa-solid fa-photo-film"></i></div>
                                <div><span>+</span></div>
                                <div><span>Imagem</span></div>
                            </button>
                        </div>
                    </div>

                    <!-- Modal adicionar arquivos -->
                    <div class="modal fade" id="addFile" tabindex="-1" aria-labelledby="addFileLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addFileLabel">{{ product.name }}</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="col-sm-12 col-lg-8 input-group mb-2">
                                        <input type="file" class="form-control" :class="errors.file ? 'is-invalid' : ''"
                                            id="validationServerFiles" aria-describedby="validationServerFilesFeedback"
                                            @change="setFile($event)">
                                        <div v-if="errors.file" id="validationServerFilesFeedback"
                                            class="invalid-feedback text-start">
                                            {{ errors.file[0] }}</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-cancel" id="cancelModal"
                                        data-bs-dismiss="modal" @click="this.errors = []">Cancelar</button>
                                    <button type="button" class="btn btn-save"
                                        @click="saveFile(product.id, this.file)">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal fim-->
                </div>
            </template>
        </div>
    </div>
</template>

<script>

import { mapState } from "vuex"
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';
import CategoryMixin from '@/mixins/CategoryMixin';

export default {

    name: 'ProductIndex',

    mixins: [AbstractMixin, ProductMixin, CategoryMixin],

    data() {
        return {
            template: 'list',
            products: [],
            product: {},
            categories: [],
            file: {},
            filter: null,
        };
    },

    computed: mapState(['categories', 'errors', 'loader']),

    mounted() {
        this.fetchCategories()
        this.fetchProducts()
    }
}
</script>

<style scoped>
.addFile {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
    width: 100px;
    height: 100px;
    padding: 10px;
    font-size: large;
    font-weight: 700;
    color: #9b9a9a;
    border: solid 1px #bebebe;
    border-radius: 5%;
}

.addFile:hover {
    color: #6b6a6a;
    border-color: #6b6a6a
}
</style>