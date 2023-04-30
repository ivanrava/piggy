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
import {useAuth} from "../composables/useAuth";

const form = ref({
    email: '',
    password: ''
})

const {login} = useAuth()
</script>

<style scoped>

</style>
