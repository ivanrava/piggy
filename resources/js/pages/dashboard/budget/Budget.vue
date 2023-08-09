<script setup lang="ts">

import {onMounted, ref} from "vue";
import axios from "axios";
import {Category} from "../../../composables/interfaces";

const isLoading = ref<boolean>(true);
const budget = ref<Array<Category>>(null);
onMounted(() => {
    axios.get('/budget').then(({data}) => {
    budget.value = data;
  }).finally(() => {
    isLoading.value = false;
  })
})
</script>

<template>
  <h1>Budget</h1>
  <pre>
    {{ budget }}
  </pre>
</template>

<style scoped>

</style>
