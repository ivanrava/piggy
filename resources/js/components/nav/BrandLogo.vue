<template>
  <img
    alt="Application logo"
    src="/logo-align-left.svg"
    class="hover:brightness-75 transition-all hidden md:block cursor-pointer h-full p-2.5"
    :class="useRoute().path === '/home' ? 'brightness-50' : ''"
    @click="router.push('/home')"
  >
  <img
    alt="Application logo"
    src="/logo-icon.svg"
    class="hover:brightness-75 transition-all block md:hidden cursor-pointer h-full p-1"
    :class="useRoute().path === '/home' ? 'brightness-50' : ''"
    @click="router.push('/home')"
  >
</template>
<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
const router = useRouter()
</script>
