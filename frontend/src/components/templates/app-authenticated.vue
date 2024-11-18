<template>
    <div v-if="isLogged" class="divBox">
        <div>&nbsp;</div>
        <div class="user">
            <UserDropdown />
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex"
import UserDropdown from "@/components/commons/user-dropdown.vue";


export default {

    name: "AppAuthenticated",

    props: {
        title: String,
    },

    components: { UserDropdown },

    computed: {
        ...mapGetters(['isLogged'])
    },


};
</script>

<style scoped>
.divBox {
    grid-area: appAuthenticated;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    background: #1f1e1e;
}

.user {
   align-self: right;
}
</style>
