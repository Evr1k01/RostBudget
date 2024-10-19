import {createRouter, createMemoryHistory} from "vue-router";
import StartPage from "../views/home/StartPage.vue";

const routes = [
    {
        path: '/',
        component: StartPage
    }
]

const router = createRouter({
    history: createMemoryHistory(),
    routes
})

export default router
