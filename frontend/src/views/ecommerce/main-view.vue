<template>
    <header>
		<HeaderBar />
	</header>

    <main class="container">
		<NotificationsList />
		<LoaderWait v-if="loader.active" :text="loader.text" />
		<router-view />
	</main>
     
</template>

<script>
import { mapState } from "vuex";
import HeaderBar from '@/components/bars/header-bar.vue'
import LoaderWait from "@/components/loaders/loader-wait.vue";
import NotificationsList from '@/components/notifications/notifications-list.vue'



export default {

    name: 'MainView',

    components: {
        HeaderBar,
        LoaderWait,
        NotificationsList
    },

    computed: mapState(['loader']),
}
</script>

<style scoped>
header {
	background-color: #203041;
}
</style>