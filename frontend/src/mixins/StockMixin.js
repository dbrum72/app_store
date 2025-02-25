import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getStocks(subFilter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock?with=product`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, null, subFilter, parameter),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                this.stocks = response.data.data
            }
        },

        async getStock(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.stock = response.data.data
                this.searchQuery = this.stock.product.name
                this.products = []
            }
        },

        async storeStock() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock`
            const response = await this.handleRequest(
                () => upstoreData(url, null, this.stock),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetStockView();
            }
        },

        async updateStock(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.stock),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetStockView(response.data.stock.id);
            }
        },

        async destroyStock(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock`
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Estoque excluído com sucesso.',
                'Erro ao excluir o estoque.'
            );
            if (response) {
                this.resetStockView();
            }
        },

        resetStockView(id) {      
            this.stock = {}
            this.SET_ERRORS([])
            id ? this.$router.push({ name: 'getStock', params: { 'id' : id}}) : this.$router.push({ name: 'getStocks' })
        },
    }
}