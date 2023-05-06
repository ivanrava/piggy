import {createRouter, createWebHistory} from "vue-router";
import {useAuth} from "../composables/useAuth";
import AuthLayout from "../layouts/AuthLayout.vue";
import DashboardLayout from "../layouts/DashboardLayout.vue";

const routes = [
    {
        path: '/',
        component: AuthLayout,
        children: [
            {
                name: 'register',
                path: '/register',
                component: () => import('@/pages/auth/Register.vue'),
                meta: {
                    title: 'Register',
                    requiresAuth: false
                }
            },
            {
                name: 'login',
                path: '/login',
                component: () => import('@/pages/auth/Login.vue'),
                meta: {
                    title: 'Login',
                    requiresAuth: false
                }
            },
        ]
    },
    {
        path: '/',
        component: DashboardLayout,
        children: [
            {
                name: 'home',
                path: '/home',
                component: () => import('@/pages/dashboard/Home.vue'),
                meta: {
                    title: 'Home',
                    requiresAuth: true
                }
            },
            {
                name: 'accounts',
                path: '/accounts',
                component: () => import('@/pages/dashboard/Accounts.vue'),
                meta: {
                    title: 'Accounts',
                    requiresAuth: true
                }
            }
        ]
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
        component: () => import('@/pages/auth/Logout.vue'),
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
    document.title = `${to.meta.title} | Piggy`
})

export default router
