import { createWebHistory, createRouter } from "vue-router";

const Login = () => import('@/pages/Login.vue')
const Register = () => import('@/pages/Register.vue')
const Me = () => import('@/pages/Me.vue')

import axios from "axios";

const routes = [
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {
            title: 'Register',
            requiresAuth: false
        }
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            title: 'Login',
            requiresAuth: false
        }
    },
    {
        name: 'me',
        path: '/me',
        component: Me,
        meta: {
            title: 'Profile information',
            requiresAuth: true
        }
    },
    {
        name: 'logout',
        path: '/logout',
        component: () => import('@/pages/Logout.vue'),
        meta: {
            title: "Logout",
            requiresAuth: true
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        axios.get('/user').then(() => {
            next();
        }).catch((error) => {
            if (error.response.status === 401) {
                next({
                    path: '/login'
                })
            }
        }).finally(() => {
            document.title = to.meta.title
        })
    } else {
        next();
    }
})

export default router
