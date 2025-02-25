<template>
    <div class="content">

        <div class="areaHeader">
            <span>USUÁRIO - Meus dados</span>
        </div>

        <div class="subarea">
            <div class="">
                <div class="">
                    <div class="row">
                        <div class="col-8 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                    id="validationServerNome" aria-describedby="validationServerNomeFeedback"
                                    placeholder="Nome" v-model="user.name" readonly>
                                <label for="validationServerNome">Nome *</label>
                                <div v-if="errors.name" id="validationServerNomeFeedback"
                                    class="invalid-feedback text-start">{{ errors.name[0] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-4 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.cnpj_cpf ? 'is-invalid' : ''"
                                    id="validationServerCpfCnpj" aria-describedby="validationServerCpfCnpjFeedback"
                                    placeholder="CPF / CNPJ" v-model="user.cnpj_cpf">
                                <label for="validationServerCpfCnpj">CPF / CNPJ *</label>
                                <div v-if="errors.cnpj_cpf" id="validationServerCpfCnpjFeedback"
                                    class="invalid-feedback text-start">
                                    {{ errors.cnpj_cpf[0] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-lg-4 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.email ? 'is-invalid' : ''"
                                    id="validationServerEmail" aria-describedby="validationServerEmailFeedback"
                                    placeholder="Email" v-model="user.email">
                                <label for="validationServerEmail">Email</label>
                                <div v-if="errors.email" id="validationServerEmailfeedback"
                                    class="invalid-feedback text-start">
                                    {{ errors.email[0] }}</div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.tel_cel ? 'is-invalid' : ''"
                                    id="validationServerTelCel" aria-describedby="validationServerTelCelFeedback"
                                    placeholder="Tel. / Cel." v-model="user.tel_cel">
                                <label for="validationServerTelCel">Tel. / Cel.</label>
                                <div v-if="errors.tel_cel" id="validationServerTelCelfeedback"
                                    class="invalid-feedback text-start">
                                    {{ errors.tel_cel[0] }}</div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 mb-2">
                            <div class="form-floating">
                                <div class="form-check text-start">
                                    <input class="form-check-input" type="checkbox" false-value="0" true-value="1"
                                        id="flexCheckDefault" v-model="user.whatsapp">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        whatsapp
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-save" type="button" @click="update(this.$store.state.user.user_id)">Salvar</button>
                    <button type="button" class="btn btn-gray" @click="this.errors = []">Cancelar</button>
                </div>
            </div>
            <div>
                <span class="obgField">* Campo obrigatório.</span>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations } from "vuex"
import http from '@/services/http.js'
import AbstractMixin from '@/mixins/AbstractMixin'

export default {

    name: 'MeusDadosView',

    mixins: [AbstractMixin],

    data() {
        return {
            user: {
                'name': '',
                'cnpj_cpf': '',
                'email': '',
                'tel_cel': '',
                'whatsapp': '',
            },
            errors: []
        };
    },

    mounted() {
        this.loadUser(this.$store.state.user.user_id)
    },

    methods: {

        ...mapMutations([
            'PUSH_NOTIFICATION'
        ]),

        loadUser(id) {

            let url = `${process.env.VUE_APP_BACKEND_URL}/user/${id}`

            this.getDadosApi(url)
                .then((result) => {
                    this.user.name = result.data.name,
                    this.user.cnpj_cpf = result.data.cnpj_cpf,
                    this.user.email = result.data.email,
                    this.user.tel_cel = result.data.tel_cel,
                    this.user.whatsapp = result.data.whatsapp
                })
        },

        async update(id) {

            this.SET_LOADER({ 'active': true, 'text': 'Salvando dados...' })

            try {
                let url = `${process.env.VUE_APP_BACKEND_URL}/user/${id}`

                let response = await http.patch(url, this.user)
                
                if (response.status == 200 || response.status == 201) {
                    this.PUSH_NOTIFICATION({
                        type: 'sucesso',
                        message: response.data.msg
                    })
                }
                this.errors = []
            }
            catch (error) {
                if (error?.response?.status === 422) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: 'Conteúdo não processável. Verifique as regras de validação.'
                    })
                    this.errors = error.response.data.errors
                    console.log(this.errors)
                }
            }
            finally {
                this.SET_LOADER({ 'active': false, 'text': '' })
            }
        },

    },
};
</script>