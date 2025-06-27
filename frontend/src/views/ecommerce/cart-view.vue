<template>
    <div class="view">
        <div class="products">
            <div class="header">
                <div>
                    <span class="title title-color-1"><i class="fa-solid fa-cart-ecommerceping cart"></i> SEU CARRINHO DE
                        COMPRAS</span>
                </div>
                <div><router-link :to="{ name: 'Produtos' }"> continue comprando</router-link></div>
            </div>
            <div v-if="COUNT_CART()" class="mt-3">
                <table class="">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                    </tr>
                    <tr v-for="(item, index) in cart" :key="index">
                        <td> {{ item.product.name }} </td>
                        <td> R$ {{ toCurrency(item.product.price) }}</td>
                        <td id="qty">
                            <div class="wrap">
                                <div class="custom-qty">
                                    <input type="button" class="control" value="-" @click="decrementItem(item.id)">
                                    <input type="text" class="qty" v-model="item.quantity" data-max="9999" size="1"
                                        readonly="readonly">
                                    <input type="button" class="control" value="+" @click="incrementItem(item.id)">
                                </div>
                            </div>
                        </td>
                        <td> R$ {{ toCurrency(item.quantity * item.product.price) }}</td>
                    </tr>
                </table>
            </div>
            <div v-else>
                <h6 class="mt-2">Você não possui produtos no carrinho.</h6>
            </div>
        </div>
        <div class="resume">
            <span class="title title-color-2">RESUMO DO PEDIDO</span>
            <span class="itens">ITENS: {{ COUNT_CART() }}</span>
            <div class="d-flex justify-content-between p-3 separate">
                <span class="subtotal"> Subtotal: </span>
                <span class="subtotal"> R$ {{ toCurrency(getSumCart()) }} </span>
            </div>
            <div class="d-flex justify-content-between p-3 separate">
                <span class="peso"> Peso: </span>
                <span class="peso"> 8 Kg</span>
            </div>
            <div class="d-flex justify-content-between p-3 subtotal">
                <span class="total"> Total: </span>
                <span class="total total-color"> R$ {{ toCurrency(getSumCart()) }} </span>
            </div>
            <div>
                <button class="btn-conclude" @click="concludeOrder()">Concluir Pedido</button>
            </div>
        </div>
    </div>
</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin'
import { mapState, mapGetters, mapMutations } from 'vuex';
import http from '@/services/http.js'

export default {

    name: 'CartView',

    data() {
        return {
            order_id: null,
            itens: []
        }
    },

    mixins: [AbstractMixin],

    computed: mapState(['cart']),

    methods: {
        ...mapGetters([
            'GET_USERID',
            'COUNT_CART',
            'getSumCart'
        ]),
        ...mapMutations([ 'PUSH_NOTIFICATION' ]),

        async startOrder() {

            try {
                let url = `${process.env.VUE_APP_BACKEND_URL}/order`

                let response = await http.post(url, { 'user_id': this.GET_USERID() })

                if (response.status == 200 || response.status == 201) {
                    this.PUSH_NOTIFICATION({
                        type: 'sucesso',
                        message: response.data.msg
                    })
                    this.order_id = response.data.order_id
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
                    this.$router.push({ name: 'Carrinho' })
                }
            }
        },

        async includeItens() {

            try {
                let url = `${process.env.VUE_APP_BACKEND_URL}/cart?with=product&filtro=user_id:=:${this.GET_USERID()}`
                this.getDadosApi(url)
                    .then((result) => {
                        let url = ''
                        result.data.forEach((item) => {
                            url = `${process.env.VUE_APP_BACKEND_URL}/orders_products`
                            http.post(url, {
                                'order_id': this.order_id,
                                'product_id': item.product_id,
                                'quantity': item.quantity,
                                'price': item.product.price
                            })
                            url = `${process.env.VUE_APP_BACKEND_URL}/cart/${item.id}`
                            http.delete(url)
                        })
                    })
            }
            catch (error) {
                if (error?.response?.status === 422) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: 'Conteúdo não processável. Verifique as regras de validação.'
                    })
                    this.errors = error.response.data.errors
                    this.$router.push({ name: 'Login' })
                }
            }
        },

        async concludeOrder() {

            this.startOrder()

            this.includeItens()

            this.loadCart()

            this.$router.push({ name: 'Carrinho' })
        },

        async decrementItem(item) {

            try {

                let url = `${process.env.VUE_APP_BACKEND_URL}/cart/${item}`

                this.getDadosApi(url)
                    .then((result, response) => {
                        let quantity = result.data.quantity

                        if (quantity > 1) {
                            response = http.patch(url, { 'quantity': quantity - 1 })
                        } else {
                            response = http.delete(url, item)
                            console.log(response.data)
                        }

                        if (response.status == 200 || response.status == 201) {
                            this.PUSH_NOTIFICATION({
                                type: 'sucesso',
                                message: response.data.msg
                            })
                        }
                        this.errors = []
                        this.loadCart()
                    })
            }
            catch (error) {
                if (error?.response?.status === 422) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: 'Conteúdo não processável. Verifique as regras de validação.'
                    })
                    this.errors = error.response.data.errors
                    this.$router.push({ name: 'Login' })
                }
            }
        },

        async incrementItem(item) {

            try {

                let url = `${process.env.VUE_APP_BACKEND_URL}/cart/${item}`

                this.getDadosApi(url)
                    .then((result, response) => {
                        let quantity = result.data.quantity

                        response = http.patch(url, { 'quantity': quantity + 1 })

                        if (response.status == 200 || response.status == 201) {
                            this.PUSH_NOTIFICATION({
                                type: 'sucesso',
                                message: response.data.msg
                            })
                        }
                        this.errors = []
                        this.loadCart()
                    })
            }
            catch (error) {
                if (error?.response?.status === 422) {
                    this.PUSH_NOTIFICATION({
                        type: 'erro',
                        message: 'Conteúdo não processável. Verifique as regras de validação.'
                    })
                    this.errors = error.response.data.errors
                    this.$router.push({ name: 'Login' })
                }
            }
        }
    }

}
</script>

<style>
.btn-conclude {
    padding: 5px;
    width: 100%;
    font-weight: 500;
    text-transform: uppercase;
    border: 0px;
    border-radius: 5px;
    background-color: #5AE8C9;
}

.btn-conclude:hover {
    background-color: #41d1b2;
}

.cart {
    padding: 12px;
    color: #fff;
    border-radius: 50%;
    background-color: #000;
}

.header {
    display: flex;
    flex-flow: row wrap;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
    padding: 10px;
    border-bottom: solid 2px #000;
}

.itens {
    padding: 10px;
    font-weight: 500;
    font-family: Roboto, sans-serif;
    color: #5AE8C9;
    text-shadow: 1px 1px #000;
    letter-spacing: 2px;
    border-bottom: solid 1px #A7A7A7;
}

.products {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    text-align: center;
    background-color: #fff;
}

.peso {
    color: #e2e1e1;
    font-family: Roboto, sans-serif;
    font-size: .95rem;
    font-weight: 200;
    letter-spacing: .7px;
}

.resume {
    display: flex;
    flex-flow: column nowrap;
    padding: 10px;
    background-color: #3b3b3b;
}

.separate {
    border-bottom: solid 1px #A7A7A7;
}

.subtotal {
    color: #e2e1e1;
    font-family: Roboto, sans-serif;
    font-size: .95rem;
    font-weight: 500;
    letter-spacing: .7px;
}

.title {
    padding: 10px;
    font-size: 28px;
    text-transform: uppercase;
    font-family: Roboto, sans-serif;
    font-weight: bold;
    font-style: normal;
    line-height: 1.2;
    text-rendering: optimizeLegibility;
}

.title-color-1 {
    color: #000;
}

.title-color-2 {
    color: #A7A7A7;
    text-shadow: 1px 2px #000;
}

.total {
    font-family: Roboto, sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    letter-spacing: 1px;
}

.total-color {
    font-family: Roboto, sans-serif;
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 1px;
    color: #5AE8C9;
}

.view {
    display: flex;
    gap: 10px;
    width: 100%;
}
</style>