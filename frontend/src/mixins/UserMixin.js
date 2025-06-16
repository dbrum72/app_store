import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from "vuex";

export default {

    methods: {

        ...mapMutations(['SET_ERRORS']),

        async getUsers(filter, extendedFilter, parameter, sort) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user`
            const response = await this.handleRequest(
                () => getCollection(url, filter, extendedFilter, parameter, sort),
                null,
                'Erro ao carregar a lista de usuários.',
                false
            );
            if (response) {
                this.users = response.data.data
            }
        },

        async getUser(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de usuários.',
                false
            );
            if (response) {
                this.user = response.data.data
            }
        },

        async storeUser() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user`
            const response = await this.handleRequest(
                () => upstoreData(url, null, this.user),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetUserView(response.data.user.id)
            }
        },

        async updateUser(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.user),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetUserView(response.data.user.id)
            }
        },

        async destroyUser(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user`
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Usere excluído com sucesso.',
                'Erro ao excluir o usuário.'
            );
            if (response) {
                this.resetUserView()
            }
        },

        resetUserView(id) {
            this.user = {}  
            this.SET_ERRORS([])
            id ? this.$router.push({ name: 'getUser', params: { 'id' : id}}) : this.$router.push({ name: 'getUsers' })
        },
    }
}