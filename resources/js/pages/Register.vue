<template>
    <h1>Register</h1>
    <form @submit.prevent="register(form)">
        <input name="name" placeholder="Name" v-model="form.name">
        <input name="email" placeholder="E-mail" v-model="form.email">
        <input name="password" placeholder="Password" v-model="form.password">
        <input placeholder="Confirm password" v-model="form.password_confirmation">
        <button>Register</button>
    </form>
    <router-link to="/login">Login link</router-link>
</template>

<script setup lang="ts">
import {ref, onMounted} from "vue"
import axios from "axios"
import {useRouter} from "vue-router";

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

interface RegisterPayload {
    name: string,
    email: string,
    password: string,
    password_confirmation: string
}

const router = useRouter()
async function register(payload: RegisterPayload) {
    const res = await axios.post("/register", payload)
    axios.post("/login", {
        email: payload.email,
        password: payload.password
    }).then(() => {
        router.push('/me')
    })
}

onMounted(() => {
    console.log(axios.defaults.baseURL)
})
</script>

<style scoped>

</style>
