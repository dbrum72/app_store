import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getStocks(subfilter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock?with=product`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, null, subfilter, parameter),
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

        async saveStock(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.stock),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetStockView();
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

        resetStockView() {
            this.getStocks()         
            this.stock = {}
            this.SET_ERRORS([])
            this.template = 'list'
        },
    }
}