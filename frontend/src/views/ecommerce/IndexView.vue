<template>

    <div>
        <h1>PRODUTOS</h1>
    </div>
    <div class="cards" v-if="(this.products && this.products.length > 0)">
        <div v-for="product in products" :key=product.id>
            <ProductCard 
                :id="product.id"
                :name="product.name"
                :src="urlBackFiles+(product.files?.[0]?.storaged ?? 'nenhumaImagem.png')"
                :description="product.description"
                :price="product.price"
                />                
        </div>
    </div>


</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';
import ProductCard from '@/components/ecommerce/product-card.vue';


export default {

    name: 'EcommerceIndex',

    mixins: [AbstractMixin, ProductMixin],

    components: { ProductCard },

    data() {
        return {
            urlBackFiles: process.env.VUE_APP_BACKEND_URL_FILES,
            filter: null,
            products: {}
        }
    },

    mounted() {
        this.getProducts(null)
    },

    //methods: {
       // filtrateProducts(filter) {
        //    this.getProducts(filter)
        //}
   // }
}
</script>

<style scoped>
.cards {
    display: flex;
    flex-flow: row wrap;
    gap: 15px;
    box-sizing:border-box
}
</style>