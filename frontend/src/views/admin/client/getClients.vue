<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTES</span>
        </div>

        <div class="p-2">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <div class="position-relative">
                    <input type="text" class="form-control pe-5" id="searchClient" placeholder="Pesquisar cliente..."
                        v-model="searchQuery">
                    <button class="position-absolute top-50 end-0 translate-middle-y me-3 search-button"
                        @click="getClients(searchQuery, null, 'name', 'name ASC')">
                        <i class="fa-solid fa-magnifying-glass"></i></button>
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
            searchQuery: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getClients(null, null, null, 'name ASC')
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: 'getClient', params: { 'id': id } })
        }
    }

}

</script>