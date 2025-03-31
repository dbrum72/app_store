<template>
     <div class="cards" v-if="(this.products && this.products.length > 0)">
        <div v-for="product in products" :key=product.id>
            <ProductCard
                :id="product.id"
                :name="product.name"
                :tree="product.category?.tree"
                :src="urlBackFiles + (product.files?.[0]?.storaged ?? 'nenhumaImagem.png')"
                :description="product.description" :price="product.price" />
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
            filter: this.$route.query.filter,
            parameter: this.$route.query.parameter,
            products: {}
        }
    },

    watch: {
        "$route.query": {
            handler(newQuery) {
                this.parameter = newQuery.parameter;
                this.filter = newQuery.filter;
                this.getProducts(null, this.filter, this.parameter);
            },
            deep: true, // Garante que mudanças em qualquer propriedade da query sejam detectadas
            immediate: true // Executa a função imediatamente ao montar o componente
        }
    },

    mounted() {
        this.getProducts(null, this.filter, this.parameter)
    }
}
</script>

<style scoped>

.cards {
    display: flex;
    flex-flow: row wrap;
    gap: 15px;
    width: fit-content;
    max-width: 1160px;
    margin: 0 auto;
}





</style>