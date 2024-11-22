import axios from "axios";
import store from "@/store"

let axiosInstance = axios.create({
    baseURL: process.env.VUE_APP_BACK_URL,
    headers: {
        'Accept': 'application/json',
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Methods": "GET,PUT,POST,DELETE,PATCH,OPTIONS"
    }
})

axiosInstance.interceptors.request.use((config) => {

    const token = document.cookie.split("; ").find((row) => row.startsWith("token="))?.split("=")[1];

    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }
    return config;

}, (error) => {

    store.commit('SET_USER', null)
    return Promise.reject(error)
})

axiosInstance.interceptors.response.use((response) => {
    
    return response

}, (error) => {
    if (error.response.status === 401) {
        store.commit('SET_USER', null)
        return window.location.href = '#/login'
    }
    return Promise.reject(error)
})

export default axiosInstance