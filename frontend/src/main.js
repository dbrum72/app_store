import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

const app = createApp(App)
    .use(store)
    .use(router)
    
app.config.globalProperties.$myEcommerce = process.env.VUE_APP_ECOMMERCE_TITLE;

app.mount('#app')
