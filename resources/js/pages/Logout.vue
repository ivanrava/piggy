<template>

</template>

<script setup lang="ts">
import axios from "axios";
import {useRouter} from "vue-router";

const router = useRouter();
axios.post("/logout").then(() => {
    router.replace("/login")
})
</script>

<style scoped>

</style>
