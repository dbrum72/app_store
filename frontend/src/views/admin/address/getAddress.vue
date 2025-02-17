<template>
    <div class="content" :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ENDEREÇO (Cliente)</span>
        </div>

        <div class="p-2">


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