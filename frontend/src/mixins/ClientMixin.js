import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from "vuex";

export default {

    methods: {

        ...mapMutations(['SET_ERRORS']),

        async getClients(filter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, filter, null, parameter),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.clients = response.data.data
            }
        },

        async getClient(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.client = response.data.data
            }
        },

        async storeClient() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client`
            const response = await this.handleRequest(
                () => upstoreData(url, null, this.client),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetClientView(response.data.client.id)
            }
        },

        async updateClient(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.client),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetClientView(response.data.client.id)
            }
        },

        async destroyClient(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client`
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Cliente excluído com sucesso.',
                'Erro ao excluir o cliente.'
            );
            if (response) {
                this.resetClientView()
            }
        },

        resetClientView(id) {
            this.client = {}  
            this.SET_ERRORS([])
            id ? this.$router.push({ name: 'getClient', params: { 'id' : id}}) : this.$router.push({ name: 'getClients' })
        },
    }
}