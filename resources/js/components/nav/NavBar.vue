<template>
  <nav class="h-16 bg-slate-200 flex justify-between items-center">
    <brand-logo class="h-full p-3 cursor-pointer" @click="router.push('home')" />
    <router-link class="p-6 text-lg text-slate-950 tracking-widest font-light uppercase" to="/logout">Logout</router-link>
  </nav>
</template>

<script setup>
import {defineComponent} from "vue";
import BrandLogo from "./BrandLogo.vue";
import {useRouter} from "vue-router";

defineComponent({
  components: {BrandLogo}
})

const router = useRouter()
</script>

<style scoped>

</style>
