import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations} from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async fetchOrders(filter = null) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/order`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, filter, parameter),
                'Lista de ordens de venda atualizada.',
                'Erro ao carregar a lista de ordens de venda.',
                false
            );
            if (response) {
                this.orders = response.data.data;
            }
        },

        async fetchOrder(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/order/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar ordem de venda.',
                false
            );
            if (response) {
                this.order = response.data.data
            }
        },

        async saveOrder(id) {
            const url = process.env.VUE_APP_BACKEND_URL + '/order'
            const response = await this.handleRequest(
                () =>  upstoreData(url, id, this.order),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetOrderView();
            }
        },

        async destroyOrder(id) {
            const url = process.env.VUE_APP_BACKEND_URL + '/order'
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Ordem de venda excluída com sucesso.',
                'Erro ao excluir o ordem de venda.'
            );
            if (response) {
                this.resetOrderView();
            }
        },

        resetOrderView() {
            this.fetchOrders()            
            this.order = {}  
            this.SET_ERRORS([])
            this.template = 'list'
        }
    }
}