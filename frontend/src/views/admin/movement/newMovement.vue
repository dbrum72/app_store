<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">MOVIMENTAÇÃO DE ESTOQUE</span>
        </div>

        <div class="p-2">
            <div class="row">
                <div class="col-sm-12 col-lg-8 mb-2">
                    <h6>Novo fluxo...
                    </h6>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <div class="form-floating">
                            <select class="form-select" :class="errors.movement ? 'is-invalid' : ''"
                                id="validationServerMovement" aria-describedby="validationServerMovementFeedback"
                                v-model="movement.movement" @change="getReasonByMovement()">
                                <option disabled selected>Selecione ...</option>
                                <option v-for="movement in movementTypes" :key="movement" :value="movement">{{
                                    movement === 'in' ? 'Entrada' : 'Saída' }}</option>
                            </select>
                            <label for="validationServerMovement">Fluxo *</label>
                            <div v-if="errors.movement" id="validationServerMovementFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.movement[0] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <div class="form-floating">
                            <select class="form-select" :class="errors.movement_reason_id ? 'is-invalid' : ''"
                                id="validationServerFlowTypeId" aria-describedby="validationServerFlowTypeIdFeedback"
                                v-model="movement.movement_reason_id" :disabled="reasonByMovement.length === 0">
                                <option disabled selected>Selecione ...</option>
                                <option v-for="reason in reasonByMovement" :key="reason.id" :value="reason.id">{{
                                    reason.reason }}</option>
                            </select>
                            <label for="validationServerFlowTypeId">Tipo *</label>
                            <div v-if="errors.movement_reason_id" id="validationServerFlowTypeIdFeedback"
                                class="invalid-feedback text-start">{{
                                    errors.movement_reason_id[0] }}</div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" :class="errors.quantity ? 'is-invalid' : ''"
                                id="validationServerQuantity" aria-describedby="validationServerQuantityFeedback"
                                placeholder="Nome" v-model="movement.quantity">
                            <label for="validationServerQuantity">Quantidade *</label>
                            <div v-if="errors.quantity" id="validationServerQuantityFeedback"
                                class="invalid-feedback text-start">{{ errors.quantity[0] }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="form-floating">
                            <input type="text" v-model="searchQuery" @input="onInputChange" placeholder="Produto *"
                                class="form-control" :class="errors.product_id ? 'is-invalid' : ''"
                                id="movementProductId" />
                            <label for="movementProductId">Produto *</label>
                            <div v-if="errors.product_id" id="movementProductIdFeedback"
                                class="invalid-feedback text-start">{{ errors.product_id[0] }}
                            </div>
                            <div v-if="products.length > 0 && searchQuery.length >= 3" class="menu-products">
                                <ul>
                                    <li v-for="product in products" :key="product.id" @click="selectProduct(product)">
                                        {{ product.name }}
                                    </li>
                                </ul>
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
                    <router-link class="btn btn-gray me-2" :to="{ name: 'getMovements' }">Cancelar</router-link>
                    <button class="btn btn-save" type="button" @click="storeMovement()">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex"
import MovementMixin from '@/mixins/MovementMixin'
import MovementReasonMixin from '@/mixins/MovementReasonMixin'
import AbstractMixin from '@/mixins/AbstractMixin'
import ProductMixin from '@/mixins/ProductMixin'
import { debounce } from 'lodash';


export default {

    name: 'NewMovement',

    mixins: [AbstractMixin, MovementMixin, MovementReasonMixin, ProductMixin],

    data() {
        return {
            movement: {},
            products: {},
            movementTypes: {},
            reasonByMovement: '',
            searchQuery: '',
            filter: '',
            loading: false
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getMovementTypes()
    },

    methods: {

        onInputChange: debounce(function () {
            if (this.searchQuery.length < 3) {
                this.products = {};
                return;
            }
            this.loading = true;
            this.getProducts(this.searchQuery, null, 'name', 'name ASC');
            this.loading = false;
        }, 500),

        selectProduct(product) {
            this.searchQuery = product.name
            this.movement.product_id = product.id
            this.products = {}
        }
    }
}
</script>

<style>
.menu-products {
    position: absolute;
    top: 100%;
    /* Faz o menu aparecer logo abaixo do input */
    left: 0;
    width: 100%;
    max-height: 200px;
    overmovement-y: auto;
    border: 1px solid #ccc;
    border-top: none;
    background-color: #f0f0f0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 100;
}

.menu-products ul {
    padding-left: 0;
    margin: 0;
}

.menu-products li {
    list-style-type: none;
    padding: 10px;
    cursor: pointer;
    font-size: 14px;
}

.menu-products li:hover {
    background-color: #e0f8e6;
}
</style>