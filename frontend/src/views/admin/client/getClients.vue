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
                        <button type="button" class="btn btn-opcoes search-button" @click="getClients(filter)"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <div>
                    <router-link class="btn btn-sm btn-green" :to="{ name: 'newClient' }"><i
                            class="fa-solid fa-plus"></i> Adicionar cliente</router-link>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(client, index) in clients" :key="index" @click="navigateTo(client.id)">
                            <td>{{ client.id }}</td>
                            <td>{{ client.name }}</td>
                            <td class="text-end"><i v-if="client.whatsapp" class="fa-brands fa-whatsapp"
                                    style="color: #41B883;"></i> {{ client.celphone }} </td>
                            <td>{{ client.email }}</td>
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
        this.getClients()
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: 'getClient', params: { 'id': id} })
        }
    }

}

</script>