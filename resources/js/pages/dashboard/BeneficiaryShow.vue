<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionDataTable from "../../components/TransactionDataTable.vue";

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
  <Transition name="fade-loading" mode="out-in">
    <div v-if="beneficiary.name == undefined">
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse"/>
    </div>
    <h1 v-else>
      Transactions with {{ beneficiary.name }}
    </h1>
  </Transition>
  <transaction-data-table :transactions="beneficiary.transactions" :fields="['account', 'category']" />
</template>

<style scoped>

</style>
