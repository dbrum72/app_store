<template>
    <div class="content" :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ENDEREÇO ({{ address.client?.name }})</span>
        </div>

        <div class="p-2">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-8 mb-2">
                        <h6>{{ `Editando... (Id. ${address.id})` }}
                        </h6>
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
                            <router-link class="btn btn-gray me-2"
                                :to="{ name: 'getUser', params: { 'id': address.client_id } }">Cancelar</router-link>
                            <button class="btn btn-save" type="button"
                                @click="editAddress(address.id, address.client_id)">Salvar</button>
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
import ClientAddressMixin from '@/mixins/UserAddressMixin';


export default {

    name: 'ClientAddressView',

    mixins: [AbstractMixin, ClientAddressMixin],

    data() {
        return {
            address: {},
            loading: false
        };
    },

    computed: mapState(['loader', 'errors']),

    mounted() {
        this.fetchAddress(this.$route.params.id)
    },

    methods: {
    }
}
</script>

<style></style>