<template>
    <div class="d-flex justify-content-between align-items-center gap-3 mb-3 p-1 bg-white">
        <div><img :src=image :alt="alt"></div>
        <div class="">
            <div class="product">
                <span class="product-name">{{ title }}</span>
            </div>
            <div>
                <span class="id">I.D.: {{ id }}</span>
            </div>
        </div>
        <div>
            <div>
                <span class="title">Estoque </span>
            </div>
            <div class="text-center">
                <span >{{ stock }}</span>
            </div>
        </div>
        <div class="price">
            <div class="text-center">
                <span class="title">Preço </span>
            </div>
            <div class="text-end">
                <span class="price-value">{{ toCurrency(price) }}</span>
            </div>
        </div>
        <div class="wrap">
            <div class="custom-quantity">
                <input type="button" class="control" value="-" @click="this.decrement">
                <input type="text" class="quantity" v-model="product.quantity" data-max="9999" size="1" value="1"
                    readonly="readonly">
                <input type="button" class="control" value="+" @click="this.increment">
            </div>
        </div>
        <div>
            <div class="me-3 ">
                <i class="fa-solid fa-cart-plus btn-addCart" title="Adicionar ao carrinho"
                    @click="PUSH_CART(product)"></i>
            </div>
        </div>

    </div>
</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin'

export default {

    name: 'ProductStrip',

    props: [
        'image',
        'title',
        'id',
        'stock',
        'price',
        'description',
        'alt'
    ],

    mixins: [AbstractMixin],

    methods: {

        increment() {
            this.product.quantity++;
        },

        decrement() {
            this.product.quantity--;
        }
    }
};
</script>

<style scoped>
a {
    color: #35495E;
    text-decoration: none
}

a:hover {
    color: #41B883
}

.btn-addCart {
    font-size: 1.3rem;
    cursor: pointer;
    color: #41B883ed;
}

.btn-addCart:hover {
    font-size: 1.5rem;
}

.card {
    width: 14.5rem;
    margin: 0px 20px 20px 0px;
    border: 1px solid #dfdfdf !important;
    box-shadow: 1px 1px 5px #cecdcd !important;

    -webkit-box-shadow: 1px 1px 5px #e6e6e6;
}

img {
    width: 6rem;
    height: 5rem;
}

.wrap {
    display: flex;
    justify-content: space-between;
    flex-flow: row nowrap;
    align-items: center;
}

.custom-quantity {
    display: flex;
    position: relative;
    border: 1px solid #c8c8c7;
    border-radius: 0;
    height: 36px;

    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
}

.control {
    vertical-align: middle;
    box-shadow: none;
    background: #e9e8e8;
    color: #999999;
    font-size: 1rem;
    border: none;
    width: 30%;
    font-weight: 400;
    font-family: Roboto, sans-serif;
}

.quantity {
    width: 40%;
    padding: 5px 2px;
    vertical-align: middle;
    text-align: center;
    box-shadow: none;
    color: #999999;
    font-size: .9rem;
    font-weight: 700;
    font-family: Roboto, sans-serif;
    border-radius: 0;
    border: none;
    box-shadow: none;
    border-left: 1px solid #c8c8c7;
    border-right: 1px solid #c8c8c7;
    background: #fff;

    -webkit-text-size-adjust: 100%;
}

.price {
    width: 90px;
}

.price-value {
    -webkit-tap-highlight-color: transparent;
    -webkit-text-size-adjust: 100%;
    color: #444444;
    font-style: normal;
    font-family: "Roboto", sans-serif;
    font-size: .9rem;
    font-weight: 700;
    line-height: 100%;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.product {
    width: 200px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.product-name {
    font: 700 .9rem Roboto, sans-serif;
    text-transform: uppercase;
    line-height: 100%;
}


.rate {
    display: flex;
    flex-flow: row nowrap;
    align-items: center;
    gap: 15px;
    width: 100%;
    margin: 0 0 15px 0;
    box-sizing: border-box;
    padding: 0px;
}

/* .addButton {
    width: 1.5rem;
    height: 1.5rem;
    padding: 0px;
    border-radius: 50%;
    color:#157347;
    background-color: rgba(21, 115, 71, 0);
}

.addButton:hover {
    width: 1rem;
    height: 1rem;
    padding: 0px;
    border: 0px;
    
    color:#fff;
    background-color: #157347;
} */

.title {
    font: 500 .9rem Roboto, sans-serif;
    line-height: 100%;
    white-space: nowrap;
    border: none;
    font-style: normal;
    color: #656363;
}


</style>
