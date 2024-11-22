<template>

    <div class="floating-cart">

        <!-- Button trigger modal -->
        <div class="btn-cart" :class="COUNT_CART() ? '' : ' empty'" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            <span class="mb-1">{{ COUNT_CART() }}</span>
                <span class="label"><i class="fa-solid fa-cart-shopping"></i></span>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Carrinho de compras ...</h1>
                </div>
                <div class="modal-body">
                    <div v-if="COUNT_CART()">
                        <CartItem v-for="(item, index) in cart" :key="index" :id=item.id
                            :product_name="item.product_name" :quantity="item.qty" :price="item.price" />
                        <div>
                            <span><b>Total: R$ {{ toCurrency(getSumCart()) }}</b></span>
                        </div>
                    </div>
                    <div v-else>
                        <i>Seu carrinho de compras está vazio.</i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-view" data-bs-dismiss="modal">Comprar mais produtos</button>
                    <button v-if="COUNT_CART()" type="button" class="btn btn-save" data-bs-dismiss="modal">Continuar</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin'
import { mapState, mapGetters } from 'vuex';
import CartItem from "@/components/shop/cart-item.vue"

export default {

    name: 'CartModal',

    components: { CartItem },

    mixins: [AbstractMixin],

    computed: mapState(['cart']),

    methods: {
        ...mapGetters([
            'COUNT_CART',
            'getSumCart'
        ]),
    },

    mounted() {
        console.log(mapState(['cart']))
    }
}
</script>

<style scoped>
.modal-dialog {
    position: absolute;
    top: 75px;
    right: 100px;
}

.floating-cart {
    position: fixed;
    display: flex;
    right: 20px;
    top: 120px;
    margin: 0;
    padding: 0;
    line-height: 1.57em;
    font-size: 12px;
    font-family: "Roboto", sans-serif;
    box-sizing: border-box;
    color: #444444;

    -webkit-tap-highlight-color: transparent;
    -webkit-text-size-adjust: 100%;
}

.btn-cart {
    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
    height: 60px;
    width: 60px;
    font-size: 1.4rem;
    border-radius: 50%;
    cursor: pointer;
    color: #5AE8C9;
    text-decoration: none;
    text-shadow: 2px 2px 2px #000;
    box-shadow: 2px 2px 5px 0 rgba(0, 0, 0, 0.75);
    background: #203041;
}

.empty {
    text-shadow: none;
    color: #fff;
}
</style>