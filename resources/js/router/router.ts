import {createRouter, createMemoryHistory} from "vue-router";
import StartPage from "../views/login/StartPage.vue";
import Home from "../views/home/Home.vue";

const routes = [
    {
        path: '/',
        component: StartPage
    },

    {
        path: '/home',
        name: 'Home',
        component: Home
    }
]

const router = createRouter({
    history: createMemoryHistory(),
    routes
})

export default router
