<template>
    <h1>Login</h1>
    <form @submit.prevent="login(form)" class="flex-col">
        <input v-model="form.email" name="email" placeholder="E-mail">
        <input v-model="form.password" name="password" placeholder="Password">
        <submit-button>Login</submit-button>
    </form>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {useAuth} from "../composables/useAuth";
import SubmitButton from "../components/SubmitButton.vue";

const form = ref({
    email: '',
    password: ''
})

const {login} = useAuth()
</script>

<style scoped>

</style>
