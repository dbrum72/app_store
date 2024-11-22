<template>
        <div class="user">
            <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                {{ GET_USERNAME }}
            </span>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" @click="goToAdmin()">Administraçao</a></li>
                <li><a class="dropdown-item" @click="logout()">Sair</a></li>
            </ul>
        </div>
</template>

<script>
import { mapGetters } from "vuex";
import AbstractMixin from '@/mixins/AbstractMixin'

export default {

    name: "UserDropdown",

    mixins: [AbstractMixin],

    computed: {

        ...mapGetters(['GET_USERNAME'])
    },

    methods: {
        goToAdmin() {
            this.$router.push({ name: 'AdminIndex' })
        }
    }
}
</script>

<style scoped>

.user {
    display: inline;
    margin-right: 20px;
    width: min-content;
    color:#787979
}
</style>