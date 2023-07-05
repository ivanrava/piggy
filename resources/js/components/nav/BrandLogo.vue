<template>
  <img
    alt="Application logo"
    src="/logo-align-left.svg"
    class="hover:brightness-75 transition-all"
    :class="useRoute().path === '/home' ? 'brightness-50' : ''"
  >
</template>
<script setup lang="ts">
import {useRoute} from "vue-router";
</script>
