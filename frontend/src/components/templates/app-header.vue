<template>
    <div class="header">
        <div>
            <img src="@/assets/logo.png">
            <router-link :to="{ name: 'Shop'}">{{ title }}</router-link>
        </div>
        <div>

        </div>
        <div class="d-flex align-items-center">
            <div v-if="!isLogged" class="me-3">
                <RouterLink class="me-3" :to="{ name: 'Login' }">Login</RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex"

export default {

    name: "AppHeader",

    props: {
        title: String,
    },

    computed: {
        ...mapGetters(['isLogged'])
    },


};
</script>

<style scoped>
.header {
    grid-area: appHeader;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #203041;

}

img {
    margin: 8px 18px;
    height: 35px;
    width: 35px;
}
</style>
