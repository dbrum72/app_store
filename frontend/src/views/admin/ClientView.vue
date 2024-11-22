<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="fontSr12w600Cg">CLIENTE</span>
        </div>

        <div class="p-2">
            <template v-if="template === 'list'">
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
                        <button type="button" class="btn btn-sm btn-view" title="Adicionar cliente"
                            @click="(client = {}, this.SET_ERRORS([]), template = 'save')"><i
                                class="fa-solid fa-plus"></i>
                            Adicionar cliente</button>
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
                                <td class="text-end">{{ client.celphone }} <i v-if="client.whatsapp"
                                        class="fa-brands fa-whatsapp" style="color: #41B883;"></i></td>
                                <td>{{ client.email }}</td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-view"
                                            @click="(fetchClient(client.id), template = 'show')" title="Visualizar"><i
                                                class="fa-regular fa-folder-open"></i></button>
                                        <button class="btn btn-sm btn-edit"
                                            @click="(fetchClient(client.id), SET_ERRORS([]), template = 'save')"
                                            title="Editar"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-delete"
                                            @click="(fetchClient(client.id), template = 'delete')" title="Excluir"><i
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
            </template>

            <template v-if="template === 'save'">
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 mb-2">
                            <h6>{{ client.id ? `Editando... (Id. ${client.id})` : 'Nova entrada...' }}
                            </h6>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-8 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                        id="clientName" aria-describedby="clientNameFeedback" placeholder="Nome"
                                        v-model="client.name">
                                    <label for="clientName">Nome *</label>
                                    <div v-if="errors.name" id="clientNameFeedback" class="invalid-feedback text-start">
                                        {{ errors.name[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.cnpj_cpf ? 'is-invalid' : ''"
                                        id="clientCnpjCpf" aria-describedby="clientCnpjCpfFeedback"
                                        placeholder="CPF/CNPJ" v-model="client.cnpj_cpf">
                                    <label for="clientCnpjCpf">CPF/CNPJ *</label>
                                    <div v-if="errors.cnpj_cpf" id="clientCnpjCpfFeedback"
                                        class="invalid-feedback text-start">{{ errors.cnpj_cpf[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.email ? 'is-invalid' : ''"
                                        id="clientEmail" aria-describedby="clientEmailFeedback" placeholder="Email"
                                        v-model="client.email">
                                    <label for="clientEmail">Email</label>
                                    <div v-if="errors.email" id="clientEmailFeedback"
                                        class="invalid-feedback text-start">{{ errors.email[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" :class="errors.celphone ? 'is-invalid' : ''"
                                        id="clientCelphone" aria-describedby="clientCelphoneFeedback"
                                        placeholder="Celular" v-model="client.celphone">
                                    <label for="validationServerNome">Celular</label>
                                    <div v-if="errors.celphone" id="clientCelphoneFeedback"
                                        class="invalid-feedback text-start">{{ errors.celphone[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2">
                                <div class="form-floating">
                                    <div class="form-check text-start">
                                        <input type="checkbox" class="form-check-input" id="flexCheckDefault"
                                            false-value="0" true-value="1" v-model="client.whatsapp">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            whatsapp
                                        </label>
                                    </div>
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
                                @click="(resetClientView(), template = 'list')">Cancelar</button>
                            <button class="btn btn-save" type="button"
                                @click="saveClient(client.id ?? null)">Salvar</button>
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
                        Confirma a exclusão do cliente de ID nº. "{{ client.id }}" ?
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-cancel me-2"
                            @click="(resetClientView(), template = 'list')">Cancelar</button>
                        <button type="button" class="btn btn-delete"
                            @click="(destroyClient(client.id))">Excluir</button>
                    </div>
                </div>
            </template>

            <template v-if="template === 'show'">
                <div class="">
                    <div class="subArea">
                        <div class="d-flex justify-content-between m-2 title-sub-area">
                            <div>
                                <span>Informações</span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-view" @click="(template = 'list')"
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
                                <router-link class="btn btn-sm btn-view" type="button"
                                    :to="{ name: 'ClientAddress' }"><i class="fa-solid fa-share"></i>Ir para
                                    endereços</router-link>
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
            </template>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import ClientMixin from '@/mixins/ClientMixin';

export default {

    name: 'ClientView',

    mixins: [AbstractMixin, ClientMixin],

    data() {
        return {
            template: 'list',
            clients: [],
            client: {},
            filter: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.fetchClients()
    }

}

</script>