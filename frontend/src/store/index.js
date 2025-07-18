import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import http from "@/services/http.js";

export default createStore({
	state: {
		user: null,
		token: localStorage.getItem("token") || null,
		cart: [],
		notifications: [],
		loader: {},
		errors: [],
		isNavbarVisible: true,
	},

	plugins: [createPersistedState()],

	getters: {
		isLogged(state) {
			return !!state.user;
		},

		getCart(state) {
			return state.cart;
		},

		GET_TOKEN(state) {
			return state.user ? state.user.token : null;
		},

		GET_USERNAME(state) {
			return state.user ? state.user.name : null;
		},

		GET_USERID(state) {
			return state.user ? state.user.user_id : null;
		},

		countCart(state) {
			return state.cart.length;
		},

		getSumCart(state) {
			return state.cart.reduce((sum, cart) => {
				return (sum += parseFloat(cart.quantity * cart.price));
			}, 0);
		},
	},

	mutations: {
		/***** USER ********************************************************************/
		/*******************************************************************************/

		SET_USER(state, user) {
			state.user = user;
		},

		SET_TOKEN(state, token) {
			state.token = token;
			localStorage.setItem("token", token);
		},

		LOGOUT(state) {
			state.user = null;
			state.token = null;
			localStorage.removeItem("token");
		},

		/***** CART ********************************************************************/
		/*******************************************************************************/

		PUSH_CART: (state, item) => {
			state.cart.push({
				...item,
			});
		},

		FILTER_CART: (state, itemToRemove) => {
			state.cart = state.cart.filter((item) => {
				return item.id != itemToRemove;
			});
		},

		/*****  ERRORS ********************************************************************/
		/*******************************************************************************/

		SET_ERRORS: (state, error) => {
			state.errors = error;
		},

		/***** NOTIFICATION *************************************************************/
		/*******************************************************************************/

		PUSH_NOTIFICATION: (state, notification) => {
			state.notifications.push({
				...notification,
				id: Date.now().toString(),
			});
		},

		FILTER_NOTIFICATION: (state, notificationToRemove) => {
			state.notifications = state.notifications.filter((notification) => {
				return notification.id != notificationToRemove.id;
			});
		},

		/***** LOADER  ******************************************************************/
		/*******************************************************************************/

		SET_LOADER: (state, payload) => {
			state.loader = payload;
		},
	},

	actions: {
		async register({ commit }, userData) {
			try {
				const url = `${process.env.VUE_APP_BACKEND_URL}/auth/register`;
				const response = await http.post(url, userData);
				commit("SET_USER", response.data.user);
				commit("SET_TOKEN", response.data.token);
				commit("SET_ERRORS", null);
			} catch (error) {
				commit(
					"SET_ERRORS",
					error.response?.data?.message || "Erro ao registrar"
				);
			}
		},

		async login({ commit }, credentials) {
			try {
				const url = `${process.env.VUE_APP_BACKEND_URL}/auth/login`;

				const response = await http.post(url, credentials);

				commit("SET_USER", response.data.user);
				commit("SET_TOKEN", response.data.token);
				commit("SET_ERRORS", null);

				commit('PUSH_NOTIFICATION', {
					type: 'success',
					message: response?.data?.msg || 'Login realizado com sucesso.'
				})

			} catch (error) {
				commit('PUSH_NOTIFICATION', {
					type: 'error',
					message: error.response?.data?.msg || "Erro no login."
				})
			}
		},

		async logout({ commit }) {
			try {
				const url = `${process.env.VUE_APP_BACKEND_URL}/auth/logout`;
				await http.post(url);
				commit("LOGOUT");
				commit('PUSH_NOTIFICATION', {
					type: 'success',
					message: 'Usuário deslogado com sucesso.'
				})
			} catch (error) {
				commit('PUSH_NOTIFICATION', {
					type: 'error',
					message: error.response?.data?.msg || "Erro ao deslogar."
				})
			}

		}
	},
});
