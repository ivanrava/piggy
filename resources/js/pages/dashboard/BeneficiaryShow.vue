<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";

const beneficiary = ref({});

const errors = ref({});
onMounted(() => {
  axios.get("/beneficiaries/"+useRoute().params.id).then(({data}) => {
    beneficiary.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
</script>

<template>
  <h1>Transactions with {{ beneficiary.name }}</h1>
  <pre>{{ beneficiary }}</pre>
</template>

<style scoped>

</style>
