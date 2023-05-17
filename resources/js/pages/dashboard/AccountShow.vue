<script setup lang="ts">
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import {AgGridVue} from "ag-grid-vue3";
import BeneficiaryRenderer from "../../components/renderers/BeneficiaryRenderer.vue";
import CategoryRenderer from "../../components/renderers/CategoryRenderer.vue";
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

const dateFormatter = (date) => {
  return (new Date(date.value)).toLocaleDateString(undefined, {weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'})
}
const currencyFormatter = (curr) => {
  return curr.value.toString() + ' €'
}
</script>

<template>
  <h1>{{ account.name }} transactions</h1>
  <ag-grid-vue
    class="ag-theme-alpine h-3/4 w-full"
    :columnDefs="[
      {headerName: 'Beneficiary', field: 'beneficiary', cellRenderer: BeneficiaryRenderer, autoHeight: true},
      {headerName: 'Category', field: 'category', cellRenderer: CategoryRenderer},
      {headerName: 'Date', field: 'date', valueFormatter: dateFormatter},
      {headerName: 'Amount', field: 'amount', valueFormatter: currencyFormatter},
    ]"
    :rowData="account.transactions"
  >
  </ag-grid-vue>
</template>

<style scoped>

</style>
