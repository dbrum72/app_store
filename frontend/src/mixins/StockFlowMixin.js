import { getData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getFlows() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/flow`
            const response = await this.handleRequest(
                () => getData(url),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                this.flows = response.data
            }
        },

        async getFlowTypes() {
            if (!this.stock.flow_id) return;
            const url = `${process.env.VUE_APP_BACKEND_URL}/flow_type/${this.stock.flow_id}`
            const response = await this.handleRequest(
                () => getData(url),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                this.flowTypes = response.data
            }
          }
    }
}