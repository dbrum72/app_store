<template>
    <div class="content">
        <div class="frame">
        
        <div class="areaHeader">
            <span>USUÁRIO</span>
        </div>

        <div class="p-3">
            <div class="mb-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="searchUser" placeholder="Pesquisar name..."
                        v-model="searchUser">
                    <label for="searchUser">Pesquisar name...</label>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-opcoes search-button" @click="loadUsers()"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>

            <div class="mb-2" v-if="(users.length > 0)">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">Tel/Cel</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="index">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.tel_cel }} <i v-if = "user.whatsapp" class="fa-brands fa-whatsapp" style="color: #008302;"></i></td>
                            <td>{{ user.email }}</td>
                            <td>
                                <button class="btn btn-sm btn-green"
                                    @click="(this.loadUser(user.id))"
                                    title="Visualizar"><i class="fa-solid fa-user"></i></button>
                                    <button class="btn btn-sm btn-blue"
                                @click="(this.loadUser(user.id))" title="Editar"><i
                                    class="fa-solid fa-user-pen"></i></button>
                                    <button class="btn btn-sm btn-red"
                                @click="(this.loadUser(user.id), this.destroy = true)"
                                title="Excluir"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <span class="lenght0">Nenhum registro localizado.</span>
            </div>
        </div>

        <template v-if="template === 'visualizar'">
            <div class="d-flex justify-content-between areaHeader">
                <div class="text-start">
                    <span>USUÁRIO</span>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-headArea me-2" title="Lista de users"
                        @click="(this.template = 'list', this.loadUsers())"><i
                            class="fa-solid fa-users"></i></button>
                </div>
            </div>
            <div class="">
                <div class="subArea">
                    <div class="title-sub-area">
                        <span>Dados pessoais</span>
                        <div class="d-flex justify-content-end m-2">
                            
                            
                        </div>
                    </div>

                    <div class="tupla">
                        <div class="field">
                            Nome
                        </div>
                        <div class="data">
                            {{ this.user.name }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            CPF/CNPJ
                        </div>
                        <div class="data">
                            {{ this.user.cnpj_cpf }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            Email
                        </div>
                        <div class="data">
                            {{ this.user.email ? this.user.email : '' }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            Tel./Cel
                        </div>
                        <div class="data">
                            {{ this.user.tel_cel ? this.user.tel_cel : '' }}{{
                                        this.user.whatsapp ? ' (whatsapp)' : '' }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            Criado em
                        </div>
                        <div class="data">
                            {{ this.user.created_at ?
                                        formatDate(this.user.created_at) :
                                        '' }}
                        </div>
                    </div>
                    <div class="tupla">
                        <div class="field">
                            Atualizado em
                        </div>
                        <div class="data">
                            {{ this.user.updated_at ?
                                        formatDate(this.user.updated_at) :
                                        '' }}
                        </div>
                    </div>
                </div>
            </div>
        </template>
        </div>
    </div>
</template>

<script>
import { mapMutations } from "vuex"
import http from '@/services/http.js'
import AbstractMixin from '@/mixins/AbstractMixin'


export default {

    name: 'UserView',

    mixins: [AbstractMixin],

    data() {
        return {
            user: {},
            user_id: null,
            users: {},
            destroy: false,
            endereco: {},
            enderecos: {},
            cep: {},
            searchUser: '',
            errors: []
        };
    },

    mounted() {
        this.loadUsers()
    },

    methods: {

        ...mapMutations([
            'SET_LOADER',
            'PUSH_NOTIFICATION',
        ]),

        async saveUser(id) {

            this.SET_LOADER({ 'active': true, 'text': 'Salvando dados...' })

            try {
                let metodo = id ? 'patch' : 'post'
                let urlSelected = id ? `${process.env.VUE_APP_BACKEND_URL}/user/${id}` : `${process.env.VUE_APP_BACKEND_URL}/user`

                let response = await http({ method: metodo, url: urlSelected, data: this.user })

                if (response.status == 200 || response.status == 201) {
                    this.PUSH_NOTIFICATION({
                        type: 'sucesso',
                        message: response.data.msg
                    })
                }
                this.errors = []
                this.loadUsers(),
                    this.template = 'list',
                    this.user = {}
            }
            catch (error) {
                if (error?.response?.status === 422) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: 'Conteúdo não processável. Verifique as regras de validação.'
                    })
                    this.errors = error.response.data.errors
                }
            }
            finally {
                this.SET_LOADER({ 'active': false, 'text': '' })
            }
        },

        loadUsers() {

            let url = process.env.VUE_APP_BACKEND_URL + '/user'

            if (this.searchUser) {
                url = url + '?filter=name:like:%' + this.searchUser + '%'
            }

            this.getDadosApi(url)
                .then((result) => {
                    this.users = result.data
                })
        },        

        async destroyUser(id) {

            this.SET_LOADER({ 'active': true, 'text': 'Excluindo dados...' })

            try {
                let url = `${process.env.VUE_APP_BACKEND_URL}/user/${id}`
                let response = await http.delete(url)
                if (response.status == '200') {
                    this.PUSH_NOTIFICATION({
                        type: 'sucesso',
                        message: response.data.msg
                    })
                    this.user = {}
                    this.errors = []
                    this.destroy = false
                    this.loadUsers()
                }
            }
            catch (error) {
                if (error?.response?.status) {
                    if (error?.response?.status == '404') {
                        this.PUSH_NOTIFICATION({
                            type: 'informe',
                            message: 'Nenhum registro foi localizado.'
                        })
                    }
                    this.errors = error.response.data.errors
                }
            }
            finally {
                this.SET_LOADER({ 'active': false, 'text': '' })
            }
        }
    },
};
</script>

<style scoped></style>