<template>
    <div class="product-datails">
        <div class="product-gallery">
            <img :src="getImageUrl(fileIndex)" alt="">
            <div class="gallery-thumbnails">
                <div class="d-flex" v-if="(product.files && product.files.length > 0)">
                    <div class="me-2" v-for="(file, index) in product.files" :key="index">
                        <div class="position-relative me-3 mb-3">
                            <img :src="getFile(file.storaged)" width="100px" height="100px" :title="file.name"
                                :alt="file.name" @click="setFileIndex(index)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-info">
            <p class="product-path">{{ product?.category?.tree }}</p>
            <h2>{{ product?.name }}</h2>
            <p class="product-code">Código do produto: {{ product?.barcode }}</p>
            <p class="price">R$ {{ product?.price }}</p>
            <p class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                45 avaliações
            </p>
            <p class="product-desription">{{ product?.description }}</p>
            <div class="product-options">
                <label for="color">Cor:</label>
                <select name="color" id="color">
                    <option value="preto">Preto</option>
                    <option value="branco">Branco</option>
                    <option value="cinza">Cinza</option>
                </select>
                <label for="quantity">Quantidade:</label>
                <input type="number" name="quantity" id="quantity" value="1">
            </div>
            <div class="button">
                <button class="btn btn-sm btn-green mb-2">
                    <i class="fas fa-shopping-cart"></i>
                    Adicionar ao carrinho
                </button>
                <button class="btn btn-sm btn-green mb-2">
                    <i class="fas fa-heart"></i>
                    Adicionar à lista de desejos
                </button>
            </div>
            <p class="delivery"><i class="fas fa-truck"></i>Estimativa de entrega: consulte nossos termos e condições.
            </p>
        </div>
    </div>
    <div class="product-specs">
        <ul class="tabs">
            <li><i class="fas fa-info-circle"></i>Detalhes</li>
            <li><i class="fas fa-undo"></i>Devolução</li>
            <li><i class="fas fa-shipping-fast"></i>Entrega</li>
        </ul>
        <div class="specs-content">
            <div>
                <p><strong>SKU:</strong>AC12345BD</p>
                <p><strong>Material externo:</strong>plástico ABS</p>
                <p><strong>Tempo de bateria:</strong>até 20 horas</p>
                <p><strong>Conectividade:</strong>Bluetooth 5.0</p>
            </div>
        </div>
    </div>
</template>

<script>
import AbstractMixin from '@/mixins/AbstractMixin';
import ProductMixin from '@/mixins/ProductMixin';

export default {

    name: 'getProduct',

    mixins: [AbstractMixin, ProductMixin],

    data() {
        return {
            fileIndex: 0,
            id: this.$route.params.id,
            product: {}
        };
    },

    watch: {
        "$route.params.id"(newId) {
            this.id = newId;
            this.fileIndex = 0;
            this.getProduct(this.id); // Dispara função ao mudar o parâmetro
        }
    },

    mounted() {
        this.getProduct(this.id)
    },

    methods: {

        getImageUrl(i) {
            return this.product?.files?.[i].storaged ? process.env.VUE_APP_BACKEND_URL_FILES + this.product.files[i].storaged : '';
        },

        setFileIndex(i) {
            this.fileIndex = i
        }
    },
};
</script>

<style>
buttons {
    display: flex;
    gap: 15px;
}

#color,
#quantity {
    width: 100px;
}

.delivery {
    font-size: 0.9rem;
    color: #3d3d3d
}

.price {
    margin: 10px 0;
    font-size: 2rem;
    color: #217373;
}

.product-datails {
    display: flex;
    gap: 40px;
}

.product-description {
    margin-bottom: 20px;
    font-size: 1rem;
    line-height: 1.6rem;
    color: #3d3d3d;
}

.product-info {
    flex: 1;
}

.product-info h2 {
    margin: 10px 0;
    font-size: 2.5rem;
    color: #3D3D3D;

}

.product-gallery {
    flex: 1;
}

.product-gallery img {
    width: 100%;
    border-radius: 10px;
}

.product-options {
    margin: 20px 0;
}

.product-options label {
    margin-top: 10px;
    display: block;
    font-weight: bold;
}

.product-options input,
.product-options select {
    margin-top: 5px;
    padding: 10px;
    border: solid 1px #333;
    border-radius: 5px;
}

.product-path,
.product-code {
    font-size: .9rm;
    color: #777;
    margin-bottom: 10px;
}

.product-specs {
    margin-top: 40px;
    padding: 20px;
    border-radius: 10px;
    background-color: #F2F2F2;
}

.gallery-thumbnails {
    display: flex;
    gap: 10px;
}

.gallery-thumbnails img {
    width: 60px;
    height: 60px;
    margin-top: 15px;
    border: solid 2px transparent;
    transition: 0.3s;
    cursor: pointer;
}

.gallery-thumbnails img:hover {
    border: solid 2px #41B883;
}

.rating {
    font-size: 1.2rem;
    color: #84B026
}

.specs-content p {
    margin: 10px 0;
    font-size: 1rem;
    color: #3a3a3a;
}

.tabs {
    display: flex;
    gap: 30px;
    margin-bottom: 20px;
    padding: 20px;
    list-style: none;
    border-bottom: solid 2px #333;
}

.tabs li {
    font-weight: bold;
    cursor: pointer;
    color: #777;
}
</style>