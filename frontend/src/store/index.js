import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";

export default createStore({

    state: {
        user: null,
        cart: [],
        notifications: [],
        loader: {},
        errors: [],
        isNavbarVisible: true
    },

    plugins: [createPersistedState()],

    getters: {        

        isLogged(state) {
            return !!state.user;
        },

        getCart(state) {
            return state.cart
        },

        GET_TOKEN(state) {
            return state.user ? state.user.access_token : null
        },

        GET_USERNAME(state) {
            return state.user ? state.user.user_name : null
        },

        GET_USERID(state) {
            return state.user ? state.user.user_id : null
        },

        COUNT_CART(state) {
            return state.cart.length
        },

        getSumCart(state) {
            return state.cart.reduce((sum, cart) => {
                return sum += parseFloat(cart.quantity * cart.price);
            }, 0);
        }
    },

    mutations: {

        /***** USER ********************************************************************/
        /*******************************************************************************/

        SET_USER: (state, payload) => {
            state.user = payload
        },

        /***** CART ********************************************************************/
        /*******************************************************************************/

        PUSH_CART: (state, item) => {
            state.cart.push({
                ...item
            })
        },

        FILTER_CART: (state, itemToRemove) => {
            state.cart = state.cart.filter(item => {
                return item.id != itemToRemove
            })
        },

        /*****  ERRORS ********************************************************************/
        /*******************************************************************************/

        SET_ERRORS: (state, payload) => {
            state.errors = payload
        },

        /***** NOTIFICATION *************************************************************/
        /*******************************************************************************/

        PUSH_NOTIFICATION: (state, notification) => {
            state.notifications.push({
                ...notification,
                id: Date.now().toString()
            })
        },

        FILTER_NOTIFICATION: (state, notificationToRemove) => {
            state.notifications = state.notifications.filter(notification => {
                return notification.id != notificationToRemove.id
            })
        },

        /***** LOADER  ******************************************************************/
        /*******************************************************************************/

        SET_LOADER: (state, payload) => {
            state.loader = payload
        },
    }
})
