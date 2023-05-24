<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";

const category = ref({});

const errors = ref({});
onMounted(() => {
  axios.get("/categories/"+useRoute().params.id).then(({data}) => {
    category.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
</script>

<template>
  <h1>Transactions under {{ category.name }}</h1>
  <pre>{{ category }}</pre>
</template>

<style scoped>

</style>
