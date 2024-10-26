import {createRouter, createMemoryHistory, createWebHistory} from "vue-router";
import StartPage from "../views/login/StartPage.vue";
import Home from "../views/home/Home.vue";

const routes = [
    {
        path: '/',
        name: 'Start',
        component: StartPage,
        meta: { requiresAuth: false },
    },

    {
        path: '/home',
        name: 'Home',
        component: Home,
        meta: { requiresAuth: true },
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('accessToken') !== null

    if (to.name === 'Start' && isAuthenticated) {
        next({name: 'Home'})
    }

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: 'Start' })
    } else {
        next()
    }
})

export default router
