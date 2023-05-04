<template>
  <main class="flex flex-col justify-center align-middle">
    <h1 class="font-serif">
      Login
    </h1>
    <form
      class="flex flex-col"
      @submit.prevent="login(form)"
    >
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
      <submit-button>Sign in</submit-button>
    </form>

    <span class="text-xs mt-4">
      Are you new here?
      <router-link to="/register">
        Create a new profile
      </router-link>
    </span>
  </main>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {useAuth} from "../composables/useAuth";
import SubmitButton from "../components/SubmitButton.vue";
import FormInput from "../components/FormInput.vue";

const form = ref({
    email: '',
    password: ''
})

const {login} = useAuth()
</script>

<style scoped>

</style>
