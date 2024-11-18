import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from "vuex";

export default {

    methods: {

        ...mapMutations(['SET_ERRORS']),

        async fetchClients(filter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, filter, parameter),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.clients = response.data.data
            }
        },

        async fetchClient(id) {
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

        async saveClient(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/client`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.client),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetClientView()
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

        resetClientView() {
            this.fetchClients()
            this.client = {}  
            this.SET_ERRORS([])
            this.template = 'list'
        },
    }
}