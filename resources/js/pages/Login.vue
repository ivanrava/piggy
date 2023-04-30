<template>
    <h1>Login</h1>
    <form @submit.prevent="login(form)">
        <input v-model="form.email" name="email" placeholder="E-mail">
        <input v-model="form.password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
</template>

<script setup lang="ts">
import {ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const form = ref({
    email: '',
    password: ''
})

interface LoginPayload {
    email: string,
    password: string
}

const router = useRouter();
async function login(payload: LoginPayload) {
    axios.post("/login", payload).then(() => {
        router.push('/me')
    })
}
</script>

<style scoped>

</style>
