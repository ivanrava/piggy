import { createWebHistory, createRouter } from "vue-router";

const Login = () => import('@/pages/Login.vue')

const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            middleware: 'guest',
            title: 'Login'
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    next()
})

export default router
