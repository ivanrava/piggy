import axios from "axios";
import {useRouter} from "vue-router";

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

export const useAuth = () => {
    const router = useRouter()
    async function getUser(): Promise<User | null> {
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
    async function login(payload: LoginPayload) {
        axios.post("/login", payload).then(() => {
            router.push('/me')
        })
    }
    async function logout() {
        axios.post("/logout").then(() => {
            router.replace("/login")
        })
    }
    async function register(payload: RegisterPayload)  {
        await axios.post("/register", payload);
        await login({
            email: payload.email,
            password: payload.password
        });
    }
    return {login, logout, register}
}
