<template>
  <main class="flex flex-col justify-center align-middle">
    <h1>Register</h1>
    <form class="flex flex-col" @submit.prevent="register(form)">
      <form-input
        v-model="form.name"
        name="name"
        placeholder="Name"
      />
      <form-input
        v-model="form.email"
        name="email"
        placeholder="E-mail"
        type="email"
      />
      <form-input
        v-model="form.password"
        name="password"
        placeholder="Password"
        type="password"
      />
      <form-input
        v-model="form.password_confirmation"
        name="password_confirmation"
        placeholder="Confirm password"
        type="password"
      />
      <submit-button>Sign up</submit-button>
    </form>
    <span class="text-xs mt-4">
      Do you already have a profile?
      <router-link to="/login">
        Go the login page
      </router-link>
    </span>
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
