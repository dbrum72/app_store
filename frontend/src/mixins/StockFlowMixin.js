import { getData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getStockFlows() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock_flow`
            const response = await this.handleRequest(
                () => getData(url),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                console.log(response.data)
                this.stock_flows = response.data
            }
        }
    }
}