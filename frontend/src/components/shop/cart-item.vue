<template>
    <div id="cart-item">        
        <div>
            <span><u> {{ product_name }} </u></span>
            <i class="fa-solid fa-cart-arrow-down btn-rmvCart" title="Retirar do carrinho" @click="FILTER_CART(id)"></i>
        </div>
        <div>
            <span> {{ quantity }} item(s) = R$ {{ toCurrency(quantity * price) }}</span>
        </div>
    </div>
</template>

<script>
import { mapMutations } from 'vuex';
import AbstractMixin from '@/mixins/AbstractMixin'

export default {

    name: 'CartItem',

    props: {
        id: Number,
        product_name: String,
        quantity: Number,
        price: Number
    },

    mixins: [AbstractMixin],

    methods: {
        ...mapMutations(['FILTER_CART'])
    }

}
</script>

<style scoped>
#cart-item {
    display: flex;
    flex-flow: column nowrap;
    margin-bottom: 20px;
    padding: 8px;
    border: solid 1px #999999;
    border-radius: 10px;
    background-color: #fff;
}

.btn-rmvCart {
    margin-left: .5rem;
    font-size: 1rem;
    cursor: pointer;
    color: red;
}

.btn-rmvCart:hover {
    font-size: 1.1rem;
}
</style>