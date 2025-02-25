<template>
    <div class="content" :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ENDEREÇO (Cliente)</span>
        </div>
        <div class="p-2">

            <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                <div class="form-floating flex-fill">
                    <input type="text" class="form-control" id="filterProduct" placeholder="Pesquisar por cliente..."
                        v-model="filter">
                    <label for="filterProduct">Pesquisar por cliente...</label>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-opcoes search-button" @click="fetchAddresses(filter)"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-green" title="Adicionar endereço"
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
                                    <button class="btn btn-sm btn-green"
                                        @click="(fetchAddress(address.id), template = 'show')" title="Visualizar"><i
                                            class="fa-regular fa-folder-open"></i></button>
                                    <button class="btn btn-sm btn-blue"
                                        @click="(fetchAddress(address.id), template = 'save')" title="Editar"><i
                                            class="fa-solid fa-pencil"></i></button>
                                    <button class="btn btn-sm btn-red"
                                        @click="(fetchAddress(address.id), template = 'delete')" title="Excluir"><i
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
            this.getClients(this.searchQuery);
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