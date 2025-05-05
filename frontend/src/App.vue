<template>

	<header>
		<HeaderBar />
	</header>

	<!--<AppAuthenticated />

		<AppHeader :title=$myEcommerce />

		<AppNavbar />

		<div class="d-flex justify-content-center m-4">
			'<LoaderWait v-if="loader.active" :text="loader.text" />'
			
			<NotificationsList />
		</div>

		<AppFooter />-->
	<main class="container">
		<LoaderWait v-if="loader.active" :text="loader.text" />
		<router-view />
	</main>

</template>

<script>
import { mapMutations, mapState } from "vuex";
import HeaderBar from '@/components/ecommerce/header-bar.vue'
//import AppAuthenticated from '@/components/templates/app-authenticated.vue'
//import AppHeader from '@/components/templates/app-header.vue'
//import AppNavbar from '@/components/templates/app-navbar.vue'
//import AppFooter from '@/components/templates/app-footer.vue'
import LoaderWait from "@/components/commons/loader-wait.vue";
//import NotificationsList from '@/components/commons/notifications-list.vue'

export default {

	name: 'AppStore',

	components: {
		HeaderBar,
		//AppAuthenticated,
		//AppHeader,
		//AppNavbar,
		//AppFooter,
		LoaderWait,
		//NotificationsList
	},

	computed: mapState(['loader']),

	methods: {

		...mapMutations(['SET_USER'])
	}
}
</script>

<style>
header {
	background-color: #203041;
}
</style>
