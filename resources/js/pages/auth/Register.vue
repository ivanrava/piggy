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
        class="!w-full"
        label="Name"
        :errors="errors.name"
      />
      <form-input
        v-model="form.email"
        class="!w-full"
        label="E-mail"
        type="email"
        :errors="errors.email"
      />
      <form-input
        v-model="form.password"
        class="!w-full"
        label="Password"
        type="password"
        :errors="errors.password"
      />
      <form-input
        v-model="form.password_confirmation"
        class="!w-full"
        label="Confirm your password"
        type="password"
        :errors="errors.password_confirmation"
      />
      <submit-button :is-loading="loading">
        Sign up
      </submit-button>
    </form>
    <span class="text-xs mt-4">
      Have a <i>deja-vu</i>?
      <router-link to="/login">
        Go to the login page
      </router-link>
    </span>
  </main>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue"
import {useAuth} from "../../composables/useAuth";
import SubmitButton from "../../components/form/inputs/SubmitButton.vue";
import FormInput from "../../components/form/inputs/FormInput.vue";

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const {register, clearErrors, errors, loading} = useAuth();

onMounted(() => {
  clearErrors();
})
</script>

<style scoped>

</style>
