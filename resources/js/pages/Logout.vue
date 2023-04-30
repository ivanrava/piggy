<template>

</template>

<script setup lang="ts">
import {useAuth} from "../composables/useAuth";

const {logout} = useAuth();
logout();
</script>

<style scoped>

</style>
