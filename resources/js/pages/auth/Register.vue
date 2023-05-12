<template>
  <main class="flex flex-col justify-center align-middle">
    <h1 class="font-serif">
      Register
    </h1>
    <form
      class="flex flex-col"
      @submit.prevent="register(form)"
    >
      <form-input
        v-model="form.name"
        name="Name"
        placeholder="Name"
        :errors="errors.name"
      />
      <form-input
        v-model="form.email"
        name="E-mail"
        placeholder="E-mail"
        type="email"
        :errors="errors.email"
      />
      <form-input
        v-model="form.password"
        name="Password"
        placeholder="Password"
        type="password"
        :errors="errors.password"
      />
      <form-input
        v-model="form.password_confirmation"
        name="Confirm your password"
        placeholder="Confirm password"
        type="password"
        :errors="errors.password_confirmation"
      />
      <submit-button :is-loading="loading">Sign up</submit-button>
    </form>
    <span class="text-xs mt-4">
      Have you got a <i>deja-vu</i>?
      <router-link to="/login">
        Go the login page
      </router-link>
    </span>
  </main>
</template>

<script setup lang="ts">
import {ref} from "vue"
import {useAuth} from "../../composables/useAuth";
import SubmitButton from "../../components/form/SubmitButton.vue";
import FormInput from "../../components/form/FormInput.vue";

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const {register, errors, loading} = useAuth();
</script>

<style scoped>

</style>
