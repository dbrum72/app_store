<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTES</span>
        </div>

        <div class="p-2">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <div class="form-floating flex-fill">
                    <input type="text" class="form-control" id="searchProduct" placeholder="Pesquisar name..."
                        v-model="filter">
                    <label for="searchProduct">Pesquisar...</label>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-opcoes search-button" @click="fetchClients(filter)"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div>
                    <router-link class="btn btn-sm btn-view" :to="{ name: 'saveClient', params:{ id: null }}"><i class="fa-solid fa-plus"></i> Adicionar cliente</router-link>
                </div>
            </div>
            <div class="mb-2">
                <h6 class="card-header">Lista de clientes...</h6>
            </div>

            <div class="mb-2" v-if="(clients && clients.length > 0)">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">CELULAR</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">Açoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(client, index) in clients" :key="index">
                            <td>{{ client.id }}</td>
                            <td>{{ client.name }}</td>
                            <td class="text-end"><i v-if="client.whatsapp" class="fa-brands fa-whatsapp"
                                    style="color: #41B883;"></i> {{ client.celphone }} </td>
                            <td>{{ client.email }}</td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <router-link class="btn btn-sm btn-view" :to="{ name: 'getClient', params:{ 'id': client.id }}"><i class="fa-regular fa-folder-open"></i></router-link>
                                    <router-link class="btn btn-sm btn-edit" :to="{ name: 'saveClient', params:{ 'id': client.id }}"><i class="fa-solid fa-pencil"></i></router-link>
                                    <router-link class="btn btn-sm btn-delete" :to="{ name: 'deleteClient', params:{ 'id': client.id }}"><i class="fa-regular fa-trash-can"></i></router-link>                                    
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
import ClientMixin from '@/mixins/ClientMixin';

export default {

    name: 'GetClients',

    mixins: [AbstractMixin, ClientMixin],

    data() {
        return {
            clients: [],
            filter: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchClients()
    }

}

</script>