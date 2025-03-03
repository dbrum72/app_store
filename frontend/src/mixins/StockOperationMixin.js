import { getData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getStockOperations() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/stock_operation`
            const response = await this.handleRequest(
                () => getData(url),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                console.log(response.data)
                this.stock_operations = response.data
            }
        }
    }
}