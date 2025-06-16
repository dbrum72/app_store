<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTE</span>
        </div>

        <div class="p-2">
            <div class="row">
                <div class="col-sm-12 col-lg-8 mb-2">
                    <h6>Nova entrada...</h6>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-8 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''"
                                id="userName" aria-describedby="userNameFeedback" placeholder="Nome"
                                v-model="user.name">
                            <label for="userName">Nome *</label>
                            <div v-if="errors.name" id="userNameFeedback" class="invalid-feedback text-start">
                                {{ errors.name[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.cnpj_cpf ? 'is-invalid' : ''"
                                id="userCnpjCpf" aria-describedby="userCnpjCpfFeedback" placeholder="CPF/CNPJ"
                                v-model="user.cnpj_cpf">
                            <label for="userCnpjCpf">CPF/CNPJ *</label>
                            <div v-if="errors.cnpj_cpf" id="userCnpjCpfFeedback" class="invalid-feedback text-start">
                                {{ errors.cnpj_cpf[0] }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-6 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.email ? 'is-invalid' : ''"
                                id="userEmail" aria-describedby="userEmailFeedback" placeholder="Email"
                                v-model="user.email">
                            <label for="userEmail">Email</label>
                            <div v-if="errors.email" id="userEmailFeedback" class="invalid-feedback text-start">{{
                                errors.email[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-3 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.celphone ? 'is-invalid' : ''"
                                id="userCelphone" aria-describedby="userCelphoneFeedback" placeholder="Celular"
                                v-model="user.celphone">
                            <label for="validationServerNome">Celular</label>
                            <div v-if="errors.celphone" id="userCelphoneFeedback" class="invalid-feedback text-start">
                                {{ errors.celphone[0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-3 mb-2">
                        <div class="form-floating">
                            <div class="form-check text-start">
                                <input type="checkbox" class="form-check-input" id="flexCheckDefault" false-value="0"
                                    true-value="1" v-model="user.whatsapp">
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
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getUsers' }">Cancelar</router-link>
                    <button class="btn btn-save" type="button" @click="storeUser()">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import UserMixin from '@/mixins/UserMixin';

export default {

    name: 'SaveUser',

    mixins: [AbstractMixin, UserMixin],

    data() {
        return {
            user: {}
        };
    },

    computed: mapState(['errors', 'loader'])
}

</script>