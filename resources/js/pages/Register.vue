<template>
    <main class="flex flex-col justify-center align-middle">
        <h1>Register</h1>
        <form @submit.prevent="register(form)">
            <form-input name="name" placeholder="Name" v-model="form.name"/>
            <form-input name="email" placeholder="E-mail" type="email" v-model="form.email"/>
            <form-input name="password" placeholder="Password" type="password" v-model="form.password"/>
            <form-input name="password_confirmation" placeholder="Confirm password" type="password" v-model="form.password_confirmation"/>
            <submit-button>Sign up</submit-button>
        </form>
        <router-link to="/login">Sign in</router-link>
    </main>
</template>

<script setup lang="ts">
import {ref} from "vue"
import {useAuth} from "../composables/useAuth";
import SubmitButton from "../components/SubmitButton.vue";
import FormInput from "../components/FormInput.vue";

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
