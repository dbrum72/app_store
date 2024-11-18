import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

const app = createApp(App)
    .use(store)
    .use(router)
    
app.config.globalProperties.$myApp = process.env.VUE_APP_TITLE;

app.mount('#app')
