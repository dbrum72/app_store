import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { getFile, storeFile, deleteFile } from '@/services/file.js';
import { mapMutations } from "vuex";

export default {

    methods: {

        ...mapMutations(['SET_ERRORS' ]),

        async getProducts(filter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/product?with=files,image,category&stockQuantity`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, filter, null, parameter),
                null,
                'Erro ao carregar a lista de produtos.',
                false
            );
            if (response) {
                this.products = response.data.data;
            }
        },

        async getProduct(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/product/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.product = response.data.data
            }
        },

        async storeProduct() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/product`
            const response = await this.handleRequest(
                () => upstoreData(url, null, this.product),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetProductView();
            }
        },

        async updateProduct(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/product`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.product),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetProductView(id);
            }
        },

        async destroyProduct(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/product`
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Produto excluído com sucesso.',
                'Erro ao excluir o produto.'
            );
            if (response) {
                this.resetProductView();
            }
        },

        fetchFile(file) {
            return getFile(file)
        },

        async saveFile(id, file) {
            const response = await this.handleRequest(
                () => storeFile(id, file),
                'Arquivo enviado com sucesso',
                'Erro ao salvar os dados.'
            );
            if (response) {
                document.getElementById('cancelModal').click() // Fecha modal                
                this.resetProductView();
            }
        },

        async destroyFile(id) {
            const response = await this.handleRequest(
                () => deleteFile(id),
                'Arquivo excluído com sucesso.',
                'Erro ao excluir o arquivo.'
            );
            if (response) {
                this.resetProductView();
            }
        },

        setFile(e) {
            this.file = e.target.files[0]
            this.SET_ERRORS([])
        },

        resetProductView(id) {
            this.product = {}
            this.SET_ERRORS([])
            id ? this.$router.push({ name: 'getProduct', params: { 'id': id }}) : this.$router.push({ name: 'getProducts'})
        },
    }


}