<template>
  <div class="flex flex-col">
    <h1>Welcome back, {{ user.name }}</h1>
    <div class="flex flex-col items-center gap-8 justify-center w-full bg-stone-100 rounded-xl p-8">
      <img class="w-1/5" src="/setup_analytics.svg" alt="No data" />
      <small class="block text-stone-600">You do not have any graph view setup. Please consider adding one here.</small>
    </div>
    <h2>Your accounts</h2>
  </div>
</template>

<script setup>
import {useAuth} from "../../composables/useAuth";

const {user} = useAuth();
</script>

<style scoped>

</style>
