import {createRouter, createWebHistory} from "vue-router";
import axios from "axios";

const routes = [
    {
        name: 'register',
        path: '/register',
        component: () => import('@/pages/Register.vue'),
        meta: {
            title: 'Register',
            requiresAuth: false
        }
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('@/pages/Login.vue'),
        meta: {
            title: 'Login',
            requiresAuth: false
        }
    },
    {
        name: 'me',
        path: '/me',
        component: () => import('@/pages/Me.vue'),
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
