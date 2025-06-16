<template>
    <div :class="{ 'blurred': loader.active }">
        <div class="areaHeader">
            <span class="font12rW600TuCg">USUÁRIOS</span>
        </div>

        <div class="p-2">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <div class="position-relative">
                    <input type="text" class="form-control pe-5" id="searchUser" placeholder="Pesquisar usuário..."
                        v-model="searchQuery">
                    <button class="position-absolute top-50 end-0 translate-middle-y me-3 search-button"
                        @click="getUsers(searchQuery, null, 'name', 'name ASC')">
                        <i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <div>
                    <router-link class="btn btn-sm btn-green" :to="{ name: 'newUser' }"><i
                            class="fa-solid fa-plus"></i> Adicionar usuário</router-link>
                </div>
            </div>
            <div class="mb-2">
                <h6 class="card-header">Lista de usuários...</h6>
            </div>

            <div class="mb-2" v-if="(users && users.length > 0)">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">CELULAR</th>
                            <th scope="col">EMAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="index" @click="navigateTo(user.id)">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td class="text-end"><i v-if="user.whatsapp" class="fa-brands fa-whatsapp"
                                    style="color: #41B883;"></i> {{ user.celphone }} </td>
                            <td>{{ user.email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <span class="lenght0">Nenhum registro localizado.</span>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin';
import UserMixin from '@/mixins/UserMixin';

export default {

    name: 'getUsers',

    mixins: [AbstractMixin, UserMixin],

    data() {
        return {
            users: [],
            searchQuery: null,
        };
    },

    computed: mapState(['errors', 'loader']),

    mounted() {
        this.getUsers(null, null, null, 'name ASC')
    },

    methods: {
        navigateTo(id) {
            this.$router.push({ name: 'getUser', params: { 'id': id } })
        }
    }

}

</script>