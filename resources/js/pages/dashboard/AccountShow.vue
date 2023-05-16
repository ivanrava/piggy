<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
const route = useRoute();

const account = ref({});
const errors = ref([]);
onMounted(() => {
  axios.get("/accounts/"+route.params.id).then(({data}) => {
    account.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
</script>

<template>
  <h1>{{ account.name }}</h1>
</template>

<style scoped>

</style>
