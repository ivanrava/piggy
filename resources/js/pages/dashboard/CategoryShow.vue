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
  <Transition name="fade-loading" mode="out-in">
    <div v-if="category.name == undefined">
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse"/>
    </div>
    <h1 v-else>
      Transactions under {{ category.name }}
    </h1>
  </Transition>
  <transaction-data-table :transactions="category.transactions" :fields="['account', 'beneficiary']" />
</template>

<style scoped>

</style>
