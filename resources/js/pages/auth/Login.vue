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
      <submit-button :is-loading="loading">
        Sign in
      </submit-button>
    </form>

    <span
      v-if="isEnabledRegistration"
      class="text-xs mt-4"
    >
      <router-link to="/register">
        Create a new profile
      </router-link>
    </span>
  </main>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useAuth} from "../../composables/useAuth";
import SubmitButton from "../../components/form/inputs/SubmitButton.vue";
import FormInput from "../../components/form/inputs/FormInput.vue";

const {login, clearErrors, errors, loading} = useAuth()
const isEnabledRegistration = ref<boolean>(import.meta.env.VITE_ENABLE_REGISTRATION);

onMounted(() => {
  clearErrors();
})
const form = ref({
    email: '',
    password: ''
})
</script>

<style scoped>

</style>
