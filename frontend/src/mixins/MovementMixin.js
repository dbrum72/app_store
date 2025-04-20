import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async getMovements(subFilter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/movement?with=product,movement_reason`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, null, subFilter, parameter),
                'Lista de estoques atualizada.',
                'Erro ao carregar a lista de estoques.',
                false
            );
            if (response) {
                this.movements = response.data.data
            }
        },

        async getMovement(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/movement/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.movement = response.data.data
                this.searchQuery = this.movement.product.name
                this.products = []
            }
        },

        async storeMovement() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/movement`
            const response = await this.handleRequest(
                () => upstoreData(url, null, this.movement),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetMovementView();
            }
        },

        async updateMovement(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/movement`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.movement),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetMovementView(response.data.movement.id);
            }
        },

        async destroyMovement(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/movement`
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Estoque excluído com sucesso.',
                'Erro ao excluir o estoque.'
            );
            if (response) {
                this.resetMovementView();
            }
        },

        resetMovementView(id) {      
            this.movement = {}
            this.SET_ERRORS([])
            id ? this.$router.push({ name: 'getMovement', params: { 'id' : id}}) : this.$router.push({ name: 'getMovements' })
        },
    }
}