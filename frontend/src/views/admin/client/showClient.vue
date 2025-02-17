<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTE</span>
        </div>

        <div class="p-2">
            <div class="">
                <div class="subArea">
                    <div class="d-flex justify-content-between m-2 title-sub-area">
                        <div>
                            <span>Informações</span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-view"
                                title="Lista de produtos"><i class="fa-solid fa-list"></i></button>
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
                    <div class="tupla">
                        <div class="field">
                            ID
                        </div>
                        <div class="data">
                            {{ this.client.id ? this.client.id : '---' }}
                        </div>
                    </div>
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
                <div class="subArea">
                    <div class="title-sub-area">
                        <span>Endereços</span>
                        <div>
                            <router-link class="btn btn-sm btn-view" :to="{ name: 'saveClient', params:{ id: null }}"><i class="fa-solid fa-plus"></i> Adicionar endereço</router-link>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column m-2" v-if="(client.addresses && client.addresses.length > 0)">
                    <div class="border border-success mb-3 border-opacity-50"
                        v-for="(address, index) in client.addresses" :key="index">
                        <div class="tupla">
                            <div class="field">
                                Logradouro
                            </div>
                            <div class="data">
                                {{ address.street ?? '' }}{{ address.complement ? ', ' + address.complement : '' }}
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
                    </div>
                </div>
                <div v-else>
                    <span class="lenght0">Nenhum endereço cadastrado.</span>
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

    name: 'ShowClient',

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