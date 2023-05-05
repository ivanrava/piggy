import axios from "axios";
import {useRouter} from "vue-router";
import {ref} from "vue";

interface LoginPayload {
    email: string,
    password: string
}

interface RegisterPayload {
    name: string,
    email: string,
    password: string,
    password_confirmation: string
}

interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: Date;
    two_factor_confirmed_at?: Date;
    two_factor_recovery_codes?: number;
    two_factor_secret?: string;
    created_at: Date;
    updated_at: Date;
}

const homePath: string = '/home';

// TODO: refactor/move into state
const user = ref<User | null>(null)
const errors = ref<Object>({})
const loading = ref<Boolean>(false)

export const useAuth = () => {
    const router = useRouter()
    async function getUser(): Promise<User | null> {
        if (user.value)
            return user.value;

        try {
            const res = await axios.get("/user")
            const user = res.data;
            return {
                ...user,
                created_at: new Date(user.created_at),
                updated_at: new Date(user.updated_at),
                email_verified_at: user.email_verified_at
                    ? new Date(user.email_verified_at)
                    : null,
                two_factor_confirmed_at: user.two_factor_confirmed_at
                    ? new Date(user.two_factor_confirmed_at)
                    : null
            }
        } catch (err) {
            return null;
        }
    }
    async function initUser() {
        user.value = await getUser()
    }
    async function login(payload: LoginPayload) {
        loading.value = true;
        axios.post("/login", payload).then(() => {
            router.push(homePath)
            errors.value = [];
        }).catch(({response}) => {
            errors.value = response.data.errors;
        }).finally(() => {
            loading.value = false;
        })
    }
    async function logout() {
        loading.value = true;
        axios.post("/logout").then(() => {
            user.value = null;
            router.replace("/login")
        }).finally(() => {
            loading.value = false;
        })
    }
    async function register(payload: RegisterPayload)  {
        loading.value = true;
        axios.post("/register", payload).then(() => {
            login({
                email: payload.email,
                password: payload.password
            });
        }).finally(() => {
            loading.value = false;
        });
    }
    return {login, logout, register, initUser, user, errors, loading}
}
