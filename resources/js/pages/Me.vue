<script setup lang="ts">
import {onMounted, ref} from "vue";
import {useAuth} from "../composables/useAuth";

const user = ref()
onMounted(() => {
    const {user:data} = useAuth()
    user.value = data.value;
})
</script>

<template>
    <pre>
        {{ user }}
    </pre>
    <router-link to="/logout">Logout</router-link>
</template>

<style scoped>

</style>
