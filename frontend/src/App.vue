<template>
	<div class="app">

		<AppAuthenticated />

		<AppHeader :title=$myApp />

		<AppNavbar />

		<div class="d-flex justify-content-center m-4">
			<LoaderWait v-if="loader.active" :text="loader.text" />
			<router-view />
			<NotificationsList />
		</div>

		<AppFooter />

	</div>
</template>

<script>
import { mapMutations, mapState } from "vuex";
import AppAuthenticated from '@/components/templates/app-authenticated.vue'
import AppHeader from '@/components/templates/app-header.vue'
import AppNavbar from '@/components/templates/app-navbar.vue'
import AppFooter from '@/components/templates/app-footer.vue'
import LoaderWait from "@/components/commons/loader-wait.vue";
import NotificationsList from '@/components/commons/notifications-list.vue'

export default {

	name: 'AppWebstore',

	components: {
		AppAuthenticated,
		AppHeader,
		AppNavbar,
		AppFooter,
		LoaderWait,
		NotificationsList
	},

	computed: mapState([ 'loader' ]),

	methods: {
		
		...mapMutations([ 'SET_USER' ]),

		setUser() {
			if (localStorage.getItem('authuser')) {
				this.SET_USER(JSON.parse(localStorage.getItem('authuser')))
			}
		},
	},

	created() {
		this.setUser	
	}
}

</script>
