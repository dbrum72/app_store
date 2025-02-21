import { getCollection, getData, upstoreData, deleteData } from '@/services/abstract.js';
import { mapMutations} from 'vuex';

export default {

    methods: {

        ...mapMutations([ 'SET_ERRORS' ]),

        async fetchCategories(filter = null) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/category`
            const parameter = 'name'
            const response = await this.handleRequest(
                () => getCollection(url, filter, parameter),
                'Lista de categorias atualizada.',
                'Erro ao carregar a lista de categoryes.',
                false
            );
            if (response) {
                this.categories = response.data.data;
            }
        },

        async fetchCategory(id) {
            const url = `${process.env.VUE_APP_BACKEND_URL}/category/${id}`
            const response = await this.handleRequest(
                () => getData(url),
                null,
                'Erro ao carregar a lista de clientes.',
                false
            );
            if (response) {
                this.category = response.data.data
            }
        },

        async storeCategory() {
            const url = process.env.VUE_APP_BACKEND_URL + '/category'
            const response = await this.handleRequest(
                () =>  upstoreData(url, null, this.category),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetCategoryView(response.data.category.id)
            }
        },
        
        async updateCategory(id) {
            const url = process.env.VUE_APP_BACKEND_URL + '/category'
            const response = await this.handleRequest(
                () =>  upstoreData(url, id, this.category),
                null,
                'Erro ao salvar os dados.'
            );
            if (response) {
                this.resetCategoryView(response.data.category.id)
            }
        },

        async destroyCategory(id) {
            const url = process.env.VUE_APP_BACKEND_URL + '/category'
            const response = await this.handleRequest(
                () => deleteData(url, id),
                'Categoria excluída com sucesso.',
                'Erro ao excluir o categoria.'
            );
            if (response) {
                this.resetCategoryView();
            }
        },

        resetCategoryView(id) {         
            this.category = {}  
            this.SET_ERRORS([])
            id ? this.$router.push({ name: 'getCategory', params: { 'id' : id}}) : this.$router.push({ name: 'getCategories' })
        }
    }
}