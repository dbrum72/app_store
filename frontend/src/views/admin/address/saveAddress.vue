<template>
    <div class="content" :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">ENDEREÇO (Cliente)</span>
        </div>

        <div class="p-2">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-8 mb-2">
                        <h6>{{ address.id ? `Editando... (Id. ${address.id})` : 'Nova entrada...' }}
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
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <input type="text" v-model="searchQuery" @input="onInputChange" placeholder="Cliente"
                                class="form-control" :class="errors.client_id ? 'is-invalid' : ''"
                                id="addressClientId" />
                            <label for="addressClientId">Cliente *</label>
                            <div v-if="errors.client_id" id="addressClientIdFeedback"
                                class="invalid-feedback text-start">{{ errors.client_id }}
                            </div>
                            <div v-if="clients.length > 0 && searchQuery.length >= 3" class="menu-clients">
                                <ul>
                                    <li v-for="client in clients" :key="client.id" @click="selectClient(client)">
                                        {{ client.name }}
                                    </li>
                                </ul>
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
                            <button type="button" class="btn btn-cancel me-2"
                                @click="(template = 'list')">Cancelar</button>
                            <button class="btn btn-save" type="button"
                                @click="saveAddress(address.id ?? null)">Salvar</button>
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
import { debounce } from 'lodash';


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
        this.fetchAddress()
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