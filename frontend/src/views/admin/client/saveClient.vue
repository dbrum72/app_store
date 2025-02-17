<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">CLIENTE</span>
        </div>

        <div class="p-2">
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
                                    id="clientCnpjCpf" aria-describedby="clientCnpjCpfFeedback" placeholder="CPF/CNPJ"
                                    v-model="client.cnpj_cpf">
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
                                <div v-if="errors.email" id="clientEmailFeedback" class="invalid-feedback text-start">{{
                                    errors.email[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.celphone ? 'is-invalid' : ''"
                                    id="clientCelphone" aria-describedby="clientCelphoneFeedback" placeholder="Celular"
                                    v-model="client.celphone">
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
                        <router-link class="btn btn-cancel me-2" :to="{ name: 'getClients'}">Cancelar</router-link>
                        <button class="btn btn-save" type="button"
                            @click="saveClient(client.id ?? null)">Salvar</button>
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

    name: 'SaveClient',

    mixins: [AbstractMixin, ClientMixin],

    data() {
        return {
            id: this.$route.params.id,
            client: {}
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.id ? this.fetchClient(this.id) : ''
    }

}

</script>