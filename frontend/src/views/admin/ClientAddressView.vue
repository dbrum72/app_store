<template>
    <div class="content" :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="fontSr12w600Cg">ENDEREÇO (Cliente)</span>
        </div>

        <div class="p-2">
            <template v-if="template === 'list'">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                    <div class="form-floating flex-fill">
                        <input type="text" class="form-control" id="filterProduct"
                            placeholder="Pesquisar por cliente..." v-model="filter">
                        <label for="filterProduct">Pesquisar por cliente...</label>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-opcoes search-button"
                                @click="fetchAddresses(filter)"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-view" title="Adicionar endereço"
                            @click="(this.SET_ADDRESS({}), template = 'save')"><i class="fa-solid fa-plus"></i>
                            Adicionar endereço</button>
                    </div>
                </div>

                <div class="mb-2">
                    <h6 class="card-header">Lista de endereços...</h6>
                </div>

                <div class="mb-2" v-if="(addresses && addresses.length > 0)">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOME</th>
                                <th scope="col">LOGRADOURO</th>
                                <th scope="col">BAIRRO</th>
                                <th scope="col">CIDADE</th>
                                <th scope="col">Principal?</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(address, index) in addresses" :key="index">
                                <td>{{ address.id }}</td>
                                <td>{{ address.client.name }}</td>
                                <td>{{ address.street }}</td>
                                <td>{{ address.district }} </td>
                                <td>{{ address.city }} </td>
                                <td class="text-center"><i v-if="address.main" class="fa-solid fa-check"
                                        style="color: #41B883;"></i>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end m-2">
                                        <button class="btn btn-sm btn-view"
                                            @click="(fetchAddress(address.id), template = 'show')" title="Visualizar"><i
                                                class="fa-regular fa-folder-open"></i></button>
                                        <button class="btn btn-sm btn-edit" @click="(fetchAddress(address.id), template = 'save')"
                                            title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-delete" @click="(fetchAddress(address.id), template = 'delete')"
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
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 mb-2">
                            <h6>{{ address.id ? `Editando... (Id. ${address.id})` : 'Nova entrada...' }}
                            </h6>
                        </div>
                        <div class="col-sm-12 col-lg-4 mb-2">
                            <div class="form-floating">
                                <div class="form-check text-start">
                                    <input type="checkbox" class="form-check-input" true-value="1"
                                        v-model="address.main">
                                    <label class="form-check-label" for="AddressMain">
                                        Principal ?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <div class="form-floating">
                                <input type="text" v-model="searchQuery" @input="onInputChange" placeholder="Cliente"
                                    class="form-control" :class="errors.client_id ? 'is-invalid' : ''"
                                    id="addressClientId" />
                                <label for="addressClientId">Cliente *</label>
                                <div v-if="errors.client_id" id="addressClientIdFeedback"
                                    class="invalid-feedback text-start">{{ errors.client_id }}
                                </div>
                                <div v-if="clients.length > 0 && searchQuery.length >= 3" class="menu-clients">
                                    <ul>
                                        <li v-for="client in clients" :key="client.id" @click="selectClient(client)">
                                            {{ client.name }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-8 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.street ? 'is-invalid' : ''"
                                        id="addressStreet" aria-describedby="addressStreetFeedback"
                                        placeholder="Logradouro" v-model="address.street">
                                    <label for="addressStreet">Logradouro *</label>
                                    <div v-if="errors.street" id="addressStreetFeedback"
                                        class="invalid-feedback text-start">{{ errors.street[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.zipcode ? 'is-invalid' : ''"
                                        id="addressZipcode" aria-describedby="addressZipcodeFeedback" placeholder="CEP"
                                        v-model="address.zipcode">
                                    <label for="addressZipcode">CEP</label>
                                    <div class="input-group-append">
                                        <button class="btn btn-opcoes search-button" type="button"
                                            @click="searchZipCode(address.zipcode)"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div v-if="errors.zipcode" id="addressZipcodeFeedback"
                                        class="invalid-feedback text-start">{{ errors.zipcode[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control"
                                        :class="errors.complement ? 'is-invalid' : ''" id="addressComplement"
                                        aria-describedby="addressComplementFeedback" placeholder="Complemento"
                                        v-model="address.complement">
                                    <label for="addressComplement">Complemento</label>
                                    <div v-if="errors.complement" id="addressComplementFeedback"
                                        class="invalid-feedback text-start">{{ errors.complement[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.district ? 'is-invalid' : ''"
                                        id="addressDistrict" aria-describedby="addressDistrictFeedback"
                                        placeholder="Bairro" v-model="address.district">
                                    <label for="addressDistrict">Bairro *</label>
                                    <div v-if="errors.district" id="addressDistrictFeedback"
                                        class="invalid-feedback text-start">{{ errors.district[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-lg-6 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.city ? 'is-invalid' : ''"
                                        id="addressCity" aria-describedby="addressCityFeedback" placeholder="Cidade"
                                        v-model="address.city">
                                    <label for="addressCity">Cidade *</label>
                                    <div v-if="errors.city" id="addressCityFeedback"
                                        class="invalid-feedback text-start">{{ errors.city[0] }}
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
                                    @click="saveAddress(address.id ?? null)">Salvar</button>
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
                        Confirma a exclusão do endereço de ID nº. "{{ address.id}}" ?
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-cancel me-2" @click="(template = 'list')">Cancelar</button>
                        <button type="button" class="btn btn-delete"
                            @click="(destroyAddress(address.id))">Excluir</button>
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
                                Cliente
                            </div>
                            <div class="data">
                                {{ address.client.name }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Logradouro
                            </div>
                            <div class="data">
                                {{ address.street }}&nbsp;&nbsp;
                                <i v-if="address.main" class="fa-solid fa-truck-arrow-right" style="color: #41B883" />
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Complemento
                            </div>
                            <div class="data">
                                {{ address.complement }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Bairro
                            </div>
                            <div class="data">
                                {{ address.district }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Cidade
                            </div>
                            <div class="data">
                                {{ address.city }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                CEP
                            </div>
                            <div class="data">
                                {{ address.zipcode }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                ID
                            </div>
                            <div class="data">
                                {{ address.id ? address.id : '---' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Criado em
                            </div>
                            <div class="data">
                                {{ address.created_at ? formatDate(address.created_at) : '' }}
                            </div>
                        </div>
                        <div class="tupla">
                            <div class="field">
                                Atualizado em
                            </div>
                            <div class="data">
                                {{ address.updated_at ? formatDate(address.updated_at) : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import ClientAddressMixin from '@/mixins/ClientAddressMixin';
import ClientMixin from '@/mixins/ClientMixin';
import { debounce } from 'lodash';


export default {

    name: 'ClientAddressView',

    mixins: [AbstractMixin, ClientAddressMixin, ClientMixin],

    data() {
        return {
            template: 'list',
            addresses: [],
            address: {},
            searchQuery: '',
            clients: {},
            filter: '',
            loading: false
        };
    },

    computed: mapState(['loader', 'errors']),

    mounted() {
        this.fetchAddresses()
    },

    methods: {

        onInputChange: debounce(function () {
            if (this.searchQuery.length < 3) {
                this.clients = [];
                return;
            }
            this.loading = true;
            this.fetchClients(this.searchQuery);
            this.loading = false;
        }, 500),

        selectClient(client) {
            this.searchQuery = client.name;
            this.address.client_id = client.id
            this.clients = []
        },
    }
}
</script>

<style>
.menu-clients {
    position: absolute;
    top: 100%;
    /* Faz o menu aparecer logo abaixo do input */
    left: 0;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-top: none;
    background-color: #f0f0f0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 100;
}

.menu-clients ul {
    padding-left: 0;
    margin: 0;
}

.menu-clients li {
    list-style-type: none;
    padding: 10px;
    cursor: pointer;
    font-size: 14px;
}

.menu-clients li:hover {
    background-color: #e0f8e6;
}
</style>