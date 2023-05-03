<template>
    <h1>Register</h1>
    <form @submit.prevent="register(form)">
        <input name="name" placeholder="Name" v-model="form.name">
        <input name="email" placeholder="E-mail" v-model="form.email">
        <input name="password" placeholder="Password" v-model="form.password">
        <input placeholder="Confirm password" v-model="form.password_confirmation">
        <submit-button>Register</submit-button>
    </form>
    <router-link to="/login">Login link</router-link>
</template>

<script setup lang="ts">
import {ref} from "vue"
import {useAuth} from "../composables/useAuth";
import SubmitButton from "../components/SubmitButton.vue";

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const {register} = useAuth();
</script>

<style scoped>

</style>
