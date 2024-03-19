import {createApp, ref} from 'vue'
import * as VueRouter from 'vue-router'
import './style.css'
import App from './App.vue'
import About from "./pages/About.vue";
import Catalog from "./pages/Catalog.vue";
import Home from "./pages/Home.vue";
import Contact from "./pages/Contact.vue";
import CardInfo from "./pages/CardInfo.vue";

export const defaultUrl = "http://localhost:4000/"
export const User = ref({auth: false})
export const visibleModal = ref('')



const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/About',
            component: About
        },
        {
            path: '/Catalog',
            component: Catalog,
        },
        {
            path: '/Contact',
            component: Contact
        },
        {
            path: '/printer/:id',
            component: CardInfo,
            props: true
        }
    ]
})
const app = createApp(App)
app.use(router)
app.mount('#app')
