import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations } from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ADDRESSES', 'SET_ADDRESS', 'SET_CLIENTS', 'SET_ERRORS' ]),

        async fetchAddresses(filter) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user_address?with=user`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, filter, null, parameter, null),
                'Lista de endereços atualizada.',
                'Erro ao carregar a lista de endereços.',
                false
            );
            if (response) {
                this.addresses = response.data.data
            }
        },

        async fetchAddress(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user_address/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de usuários.',
                false
            );
            if (response) {
                this.address = response.data.data
            }
        },

        async newAddress() {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user_address`
            const response = await this.handleRequest(
                () => upstoreData(url, null, this.address),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetAddressView(this.address.user_id);
            }
        },

        async editAddress(id, user_id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user_address`
            const response = await this.handleRequest(
                () => upstoreData(url, id, this.address),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetAddressView(user_id);
            }
        },

        async destroyAddress(id, user_id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/user_address`
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Endereço excluído com sucesso.',
                'Erro ao excluir o endereço.'
            );
            if (response) {
                this.resetAddressView(user_id);
            }
        },

        resetAddressView(id) {
            this.address = {}; // Reseta o endereço
            this.SET_ERRORS([]) // Reseta os erros
            this.$router.push({ name: 'getUser', params: { 'id': id}})
        },
    }
}