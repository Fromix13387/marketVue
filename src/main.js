import {createApp, reactive, ref} from 'vue'
import * as VueRouter from 'vue-router'
import './style.css'
import App from './App.vue'
import About from "./pages/About.vue";
import Catalog from "./pages/Catalog.vue";
import Home from "./pages/Home.vue";
import Contact from "./pages/Contact.vue";
import CardInfo from "./pages/CardInfo.vue";
import Basket from "./pages/Basket.vue";
import Messages from "./pages/Messages.vue";
import MyProfile from "./pages/MyProfile.vue";
import {Fetch} from "./api/Fetch.js";
import AdminPanel from "./pages/AdminPanel/AdminPanel.vue";
import Users from "./pages/AdminPanel/Users.vue";
import "vue-select/dist/vue-select.css";
import './global/_variables.css'
import HistoryBuy from "./pages/HistoryBuy.vue";
export const defaultUrl = "http://localhost:4000/"
export const User = reactive({auth: false})
export const visibleModal = ref('')
export const AdminPath = ['/Basket', '/Messages', '/MyProfile', '/HistoryBuy']


const checkAuth = async () => {
    const res = await Fetch({method: 'checkAuth'})
    console.log(res)
    if (res.token) {
        localStorage.setItem('token', res.token)
        for (const key in res) {
            User[key] = res[key]
        }
        User.auth = true
        return true
    }
    return false
}
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
        },
        {
            path: '/Basket',
            component: Basket,
        },
        {
            path: '/Messages',
            component: Messages,
        },
        {
            path: '/MyProfile',
            component: MyProfile,
        },
        {
            path: '/HistoryBuy',
            component: HistoryBuy,
        },
        {
            path: '/AdminPanel',
            component: AdminPanel,
            children: [
                // {
                //     path: 'booking',
                //     component: Booking
                // },
                {
                    path: 'users',
                    component: Users
                }]
                // {
                //     path: 'quests',
                //     component: Quests
                // },
                // {
                //     path: 'messages',
                //     component: Messages
                // }]
        }
    ]
})
router.beforeEach(async(to, from, next) => {
    console.log(to)
    if (User.auth !== true && !(await checkAuth()) &&  (AdminPath.includes(to.path) || to.path.includes('AdminPanel'))) {
        visibleModal.value = 'authorization'
        next({
            path: '/',
            component: Home
        })
    }
    next()
})
const app = createApp(App)
app.use(router)
app.mount('#app')

