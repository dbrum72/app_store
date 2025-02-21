<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="d-flex justify-content-between align-items-center">
            <div class="areaHeader">
                <span class="font12rW600TuCg">CLIENTE</span>
            </div>
            <div>
                <router-link class="btn btn-sm btn-view" :to="{ name: 'getClients' }" title="Lista de clientes"><i
                        class="fa-solid fa-list"></i></router-link>
            </div>
        </div>
        <div class="subArea mb-5">
            <div class="d-flex justify-content-between m-2 title-sub-area">
                <div>
                    <span>Dados Pessoais</span>
                </div>
                <div class="d-flex justify-content-end">
                    <router-link class="btn btn-sm btn-edit"
                        :to="{ name: 'editClient', params: { 'id': client.id } }" title="Editar"><i
                            class="fa-solid fa-pencil"></i></router-link>
                    <router-link class="btn btn-sm btn-delete"
                        :to="{ name: 'deleteClient', params: { 'id': client.id } }" title="Excluir"><i
                            class="fa-regular fa-trash-can"></i></router-link>
                </div>
            </div>
            <div class="dados">
                <div class="tupla">
                    <div class="field">
                        ID
                    </div>
                    <div class="data">
                        {{ this.client.id }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Nome
                    </div>
                    <div class="data">
                        {{ client.name }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        CPF/CNPJ
                    </div>
                    <div class="data">
                        {{ client.cnpj_cpf }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Celular
                    </div>
                    <div class="data">
                        {{ client.celphone }}
                        <i v-if="client.whatsapp" class="fa-brands fa-whatsapp" style="color: #41B883;"></i>
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Email
                    </div>
                    <div class="data">
                        {{ client.email }}
                    </div>
                </div>
            </div>
        </div>
        <div class="subArea mb-5">
            <div class="title-sub-area">
                <span>Endereços</span>
                <div>
                    <router-link class="btn btn-sm btn-view"
                        :to="{ name: 'newAddress', params: { 'client_id': id } }"><i class="fa-solid fa-plus"></i>
                        Adicionar endereço</router-link>
                </div>
            </div>

            <div class="d-flex flex-column m-2" v-if="(client.addresses && client.addresses.length > 0)">
                <div class="dados mb-3" v-for="(address, index) in client.addresses" :key="index">
                    <div class="tupla">
                        <div class="field">
                            Logradouro
                        </div>
                        <div class="data">
                            {{ address.street ?? '' }}{{ address.complement ? ', ' + address.complement : '' }} <i
                                v-if="address.main" class="fa-solid fa-shipping-fast"></i>
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            Bairro
                        </div>
                        <div class="data">
                            {{ address.district ?? '' }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            Cidade
                        </div>
                        <div class="data">
                            {{ address.city ?? '' }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            CEP
                        </div>
                        <div class="data">
                            {{ address.zipcode ?? '' }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <router-link class="btn btn-sm btn-edit"
                            :to="{ name: 'editAddress', params: { 'id': address.id } }" title="Editar"><i
                                class="fa-solid fa-pencil"></i></router-link>
                        <router-link class="btn btn-sm btn-delete"
                            :to="{ name: 'deleteAddress', params: { 'id': address.id } }" title="Excluir"><i
                                class="fa-regular fa-trash-can"></i></router-link>
                    </div>
                </div>
            </div>
            <div v-else>
                <span class="lenght0">Nenhum endereço cadastrado.</span>
            </div>
        </div>
        <div class="subArea">
            <div class="title-sub-area">
                <span>Atualizações</span>
            </div>
            <div class="dados">
                <div class="tupla">
                    <div class="field">
                        Criado em
                    </div>
                    <div class="data">
                        {{ this.client.created_at ? formatDate(this.client.created_at) : '' }}
                    </div>
                </div>
                <div class="tupla">
                    <div class="field">
                        Atualizado em
                    </div>
                    <div class="data">
                        {{ this.client.updated_at ? formatDate(this.client.updated_at) : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import ClientMixin from '@/mixins/ClientMixin';

export default {

    name: 'GetClient',

    mixins: [AbstractMixin, ClientMixin],

    data() {
        return {
            id: this.$route.params.id,
            client: {},
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchClient(this.id)
    }

}

</script>