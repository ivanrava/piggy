<template>
  <img
    alt="Application logo"
    src="/logo-align-left.svg"
    class="hover:brightness-50 transition-all hidden md:block cursor-pointer h-full p-2.5 dark:invert"
    :class="useRoute().path === '/home' ? 'brightness-50 dark:brightness-0' : 'dark:brightness-125 dark:opacity-90'"
    @click="router.push('/home')"
  >
  <img
    alt="Application logo"
    src="/logo-icon.svg"
    class="hover:brightness-50 transition-all block md:hidden cursor-pointer h-full p-1 dark:invert"
    :class="useRoute().path === '/home' ? 'brightness-50 dark:brightness-0' : 'dark:brightness-125 dark:opacity-90'"
    @click="router.push('/home')"
  >
</template>
<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
const router = useRouter()
</script>
