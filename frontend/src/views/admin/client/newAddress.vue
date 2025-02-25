<template>
    <div class="content" :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ENDEREÇO (Cliente)</span>
        </div>

        <div class="p-2">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-8 mb-2">
                        <h6>Nova entrada...</h6>
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <div class="form-floating">
                            <div class="form-check text-start">
                                <input type="checkbox" class="form-check-input" true-value="1" v-model="address.main">
                                <label class="form-check-label" for="AddressMain">
                                    Principal ?
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <input type="text" v-model="client.name" placeholder="Cliente"
                                class="form-control" readonly />
                            <label for="addressClientId">Cliente</label>
                            <div v-if="errors.client_id" id="addressClientIdFeedback"
                                class="invalid-feedback text-start">{{ errors.client_id }}
                            </div>
                            <div>
                                <input type="text" v-model="address.client_id" hidden />
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.street ? 'is-invalid' : ''"
                                    id="addressStreet" aria-describedby="addressStreetFeedback" placeholder="Logradouro"
                                    v-model="address.street">
                                <label for="addressStreet">Logradouro *</label>
                                <div v-if="errors.street" id="addressStreetFeedback"
                                    class="invalid-feedback text-start">{{ errors.street[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.zipcode ? 'is-invalid' : ''"
                                    id="addressZipcode" aria-describedby="addressZipcodeFeedback" placeholder="CEP"
                                    v-model="address.zipcode">
                                <label for="addressZipcode">CEP</label>
                                <div class="input-group-append">
                                    <button class="btn btn-opcoes search-button" type="button"
                                        @click="searchZipCode(address.zipcode)"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                                <div v-if="errors.zipcode" id="addressZipcodeFeedback"
                                    class="invalid-feedback text-start">{{ errors.zipcode[0] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.complement ? 'is-invalid' : ''"
                                    id="addressComplement" aria-describedby="addressComplementFeedback"
                                    placeholder="Complemento" v-model="address.complement">
                                <label for="addressComplement">Complemento</label>
                                <div v-if="errors.complement" id="addressComplementFeedback"
                                    class="invalid-feedback text-start">{{ errors.complement[0] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.district ? 'is-invalid' : ''"
                                    id="addressDistrict" aria-describedby="addressDistrictFeedback" placeholder="Bairro"
                                    v-model="address.district">
                                <label for="addressDistrict">Bairro *</label>
                                <div v-if="errors.district" id="addressDistrictFeedback"
                                    class="invalid-feedback text-start">{{ errors.district[0] }}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6 mb-2">
                            <div class="form-floating">
                                <input type="text" class="form-control" :class="errors.city ? 'is-invalid' : ''"
                                    id="addressCity" aria-describedby="addressCityFeedback" placeholder="Cidade"
                                    v-model="address.city">
                                <label for="addressCity">Cidade *</label>
                                <div v-if="errors.city" id="addressCityFeedback" class="invalid-feedback text-start">{{
                                    errors.city[0] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="obgField">* Campo obrigatório.</span>
                        </div>
                        <div class="card-footer text-end">
                            <router-link class="btn btn-gray me-2" :to="{ name: 'getClient', params: { 'id': client_id }}">Cancelar</router-link>
                            <button class="btn btn-save" type="button"
                                @click="newAddress()">Salvar</button>
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

export default {

    name: 'NewAddress',

    mixins: [AbstractMixin, ClientAddressMixin, ClientMixin],

    data() {
        return {
            client: {},
            client_id: this.$route.params.client_id,
            address: {},            
            loading: false
        };
    },

    computed: mapState(['loader', 'errors']),

    mounted() {
        this.getClient(this.client_id)
        this.address.client_id = this.client_id
    }
}
</script>

<style>

</style>