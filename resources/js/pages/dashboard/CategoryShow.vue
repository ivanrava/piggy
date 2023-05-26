<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionDataTable from "../../components/TransactionDataTable.vue";

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
  <transaction-data-table :transactions="category.transactions" :fields="['account', 'beneficiary']" />
</template>

<style scoped>

</style>
