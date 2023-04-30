import { createWebHistory, createRouter } from "vue-router";

const Login = () => import('@/pages/Login.vue')
const Register = () => import('@/pages/Register.vue')
const Me = () => import('@/pages/Me.vue')

const routes = [
    {
        name: 'register',
        path: '/register',
        component: Register,
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            middleware: 'guest',
            title: 'Login'
        }
    },
    {
        name: 'me',
        path: '/me',
        component: Me,
    },
    {
        name: 'logout',
        path: '/logout',
        component: () => import('@/pages/Logout.vue')
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
