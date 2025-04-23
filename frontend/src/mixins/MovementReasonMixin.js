import { getData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getMovementTypes() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/movementTypes`
            const response = await this.handleRequest(
                () => getData(url),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                this.movementTypes = response.data
            }
        },

        async getReasonByMovement() {
            if (!this.movement.movement) return;
            const url = `${process.env.VUE_APP_BACKEND_URL}/reasonByMovement/${this.movement.movement}`
            const response = await this.handleRequest(
                () => getData(url),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                this.reasonByMovement = response.data
            }
          }
    }
}