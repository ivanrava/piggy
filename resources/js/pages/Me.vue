<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const user = ref({});
onMounted(async () => {
    const {data} = await axios.get('/user');
    user.value = data;
})
</script>

<template>
    <pre>
        {{ user }}
    </pre>
</template>

<style scoped>

</style>
