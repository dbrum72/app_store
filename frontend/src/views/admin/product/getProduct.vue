<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="d-flex areaHeader">
            <span class="font12rW600TuCg pe-2">PRODUTO</span>
            <router-link class="btn btn-sm btn-gray" :to="{ name: 'getProducts' }" title="Lista de produtos"><i
                class="fa-solid fa-list"></i></router-link>
        </div>
        <div class="subArea mb-5">
            <div class="d-flex justify-content-between m-2 title-sub-area">
                <div><span>Informações</span></div>
                <div class="d-flex justify-content-end m-2">                    
                    <router-link class="btn btn-sm btn-blue" :to="{ name: 'editProduct', params: { 'id': product.id } }"
                        title="Editar"><i class="fa-solid fa-pencil"></i></router-link>
                    <router-link class="btn btn-sm btn-red" :to="{ name: 'deleteProduct', params: { 'id': product.id } }" title="Excluir"><i
                            class="fa-regular fa-trash-can"></i></router-link>
                </div>
            </div>
            <div class="dados">
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
                        Código
                    </div>
                    <div class="data">
                        {{ this.product.barcode ? this.product.barcode : '---' }}
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
                        Categoria
                    </div>
                    <div class="data">
                        {{ this.product.category ? this.product.category['tree'] : '---' }}
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

        <div class="subArea mb-5">
            <div class="title-sub-area">
                <span>Estoque</span>
                <div class="d-flex justify-content-end m-2">
                    <router-link class="btn btn-sm btn-green" type="button" :to="{ name: 'getStock' }"><i
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

        <div class="subArea mb-5" v-if="product.id">
            <div class="title-sub-area">
                <span>Lista de arquivos</span>
            </div>
        </div>
        <div class="d-flex m-2">
            <div class="d-flex" v-if="(product.files && product.files.length > 0)">
                <div class="me-2" v-for="(file, index) in product.files" :key="index">
                    <div class="position-relative me-3 mb-3">
                        <img :src="getFile(file.storaged)" width="100px" height="100px" :title="file.name"
                            :alt="file.name">
                        <button class="btn-trash btn-red" title="Excluir" @click="destroyFile(file.id)"><i
                                class="fa-solid fa-trash"></i></button>
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
        <div class="modal fade" id="addFile" tabindex="-1" aria-labelledby="addFileLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-gray" id="cancelModal" data-bs-dismiss="modal"
                            @click="this.errors = []">Cancelar</button>
                        <button type="button" class="btn btn-save"
                            @click="saveFile(product.id, this.file)">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal fim-->
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
            id: this.$route.params.id,
            products: [],
            product: {},
            categories: [],
            file: {},
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getCategories()
        this.getProduct(this.id)
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