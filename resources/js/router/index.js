import {createRouter, createWebHistory} from "vue-router";
import {useAuth} from "../composables/useAuth";

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

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        const {user, initUser} = useAuth()
        await initUser()
        if (!user.value) {
            next({
                path: '/login'
            })
        } else {
            next();
        }
    } else {
        next();
    }
    document.title = to.meta.title
})

export default router
