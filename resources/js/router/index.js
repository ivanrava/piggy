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
                path: '/',
                redirect: 'home',
                meta: {
                    requiresAuth: true
                }
            },
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
                component: () => import('@/pages/dashboard/accounts/Accounts.vue'),
                meta: {
                    title: 'Accounts',
                    requiresAuth: true
                }
            },
            {
                name: 'accounts.id',
                path: '/accounts/:id',
                component: () => import('@/pages/dashboard/accounts/AccountShow.vue'),
                meta: {
                    title: 'Account details',
                    requiresAuth: true
                }
            },
            {
                name: 'accounts.id.transactions',
                path: '/accounts/:id/transactions',
                component: () => import('@/pages/dashboard/accounts/AccountTable.vue'),
                meta: {
                    title: 'Account transactions',
                    requiresAuth: true
                }
            },
            {
                name: 'categories',
                path: '/categories',
                component: () => import('@/pages/dashboard/categories/Categories.vue'),
                meta: {
                    title: 'Categories',
                    requiresAuth: true
                }
            },
            {
                name: 'categories.id',
                path: '/categories/:id',
                component: () => import('@/pages/dashboard/categories/CategoryShow.vue'),
                meta: {
                    title: 'Category details',
                    requiresAuth: true
                }
            },
            {
                name: 'categories.id.transactions',
                path: '/categories/:id/transactions',
                component: () => import('@/pages/dashboard/categories/CategoryTable.vue'),
                meta: {
                    title: 'Category transactions',
                    requiresAuth: true
                }
            },
            {
                name: 'beneficiaries',
                path: '/beneficiaries',
                component: () => import('@/pages/dashboard/beneficiaries/Beneficiaries.vue'),
                meta: {
                    title: 'Beneficiaries',
                    requiresAuth: true
                }
            },
            {
                name: 'beneficiaries.id',
                path: '/beneficiaries/:id',
                component: () => import('@/pages/dashboard/beneficiaries/BeneficiaryShow.vue'),
                meta: {
                    title: 'Beneficiary details',
                    requiresAuth: true
                }
            },
            {
                name: 'beneficiaries.id.transactions',
                path: '/beneficiaries/:id/transactions',
                component: () => import('@/pages/dashboard/beneficiaries/BeneficiaryTable.vue'),
                meta: {
                    title: 'Beneficiary transactions',
                    requiresAuth: true
                }
            },
            {
                name: 'stats',
                path: '/stats',
                component: () => import('@/pages/dashboard/stats/StatsCreate.vue'),
                meta: {
                    title: 'New statistic',
                    requiresAuth: true
                }
            },
            {
                name: 'report',
                path: '/report',
                component: () => import('@/pages/dashboard/report/ReportCreate.vue'),
                meta: {
                    title: 'New report',
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
    },
    {
        name: '404',
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/NotFound.vue'),
        meta: {
            title: "Not found",
            requiresAuth: false
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
