<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="fontSr12w600Cg">CATEGORIA</span>
        </div>

        <div class="p-2">
            <template v-if="template === 'list'">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="form-floating flex-fill">
                        <input type="text" class="form-control" id="filterCategory" placeholder="Pesquisar name..."
                            v-model="filter">
                        <label for="filterCategory">Pesquisar name...</label>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-opcoes search-button"
                                @click="fetchCategories(filter)"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-view" title="Adicionar category"
                            @click="(category = {}, this.SET_ERRORS([]), template = 'save')"><i
                                class="fa-solid fa-plus"></i> Adicionar categoria</button>
                    </div>
                </div>
                <div class="mb-2">
                    <h6 class="card-header">Lista de categorias...</h6>
                </div>


                <div class="mb-2" v-if="(categories && categories.length > 0)">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOME</th>
                                <th scope="col">ÁRVORE</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in categories" :key="index">
                                <td>{{ category.id }}</td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.tree }}</td>
                                <td>
                                    <div class="d-flex justify-content-end m-2">
                                        <button class="btn btn-sm btn-view"
                                            @click="(fetchCategory(category.id), template = 'show')"
                                            title="Visualizar"><i class="fa-regular fa-folder-open"></i></button>
                                        <button class="btn btn-sm btn-edit" @click="(fetchCategory(category.id), template = 'save')"
                                            title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-delete" @click="(fetchCategory(category.id), template = 'delete')"
                                            title="Excluir"><i class="fa-regular fa-trash-can"></i></button>

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
                    <h6>{{ category.id ? `Editando... (Id. ${category.id})` : 'Nova categoria...' }}
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
                            <button type="button" class="btn btn-cancel me-2"
                                @click="this.category = {}, this.template = 'list'">Cancelar</button>
                            <button type="button" class="btn btn-save"
                                @click="saveCategory(category.id ? category.id : null)">Salvar</button>
                        </div>
                    </div>
                </div>
            </template>

            <template v-if="template === 'show'">
                <div class="">
                    <div class="subArea">
                        <div class="title-sub-area">
                            <div><span>Informações</span></div>
                            <div>
                                <button class="btn btn-sm btn-view" @click="(template = 'list')"
                                    title="Lista de categorias"><i class="fa-solid fa-list"></i></button>
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
                                ID
                            </div>
                            <div class="data">
                                {{ category.id ? category.id : '---' }}
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
            </template>

            <template v-if="template === 'delete'">
                <div class="box show">
                    <div class="fs-4 pb-2 mb-4 border-bottom border-dark">
                        <span>Atenção</span>
                    </div>
                    <div style="margin: 10px;">
                        Confirma a exclusão da categoria de ID nº. "{{ category.id }}" ?
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-cancel me-2"
                            @click="(this.template = 'list')">Cancelar</button>
                        <button type="button" class="btn btn-delete"
                            @click="(this.destroyCategory(this.category.id))">Excluir</button>
                    </div>
                </div>
            </template>
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
            template: 'list',
            categories: [],
            category: {},
            filter: '',
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchCategories()
    }
}
</script>

<style></style>