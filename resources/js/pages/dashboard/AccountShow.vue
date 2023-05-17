<script setup lang="ts">
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
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

const gridApi = ref({});
const onGridReady = (params) => {
  gridApi.value = params.api;
  params.api.sizeColumnsToFit({
    defaultMinWidth: 100,
  })
}

const stringComparator = (valA, valB) => {
  if (valA.name == valB.name)
    return 0;
  return (valA.name > valB.name) ? 1 : -1;
}
</script>

<template>
  <h1>{{ account.name }} transactions</h1>
  <ag-grid-vue
    class="ag-theme-material h-3/4 w-full"
    :animate-rows="true"
    :default-col-def="{sortable: true}"
    :column-defs="[
      {
        headerName: 'Beneficiary', field: 'beneficiary',
        cellRenderer: BeneficiaryRenderer, autoHeight: true,
        comparator: stringComparator
      },
      {
        headerName: 'Category', field: 'category',
        cellRenderer: CategoryRenderer,
        comparator: stringComparator
      },
      {
        headerName: 'Date', field: 'date',
        type: 'rightAligned',
        valueFormatter: dateFormatter
      },
      {
        headerName: 'Amount', field: 'amount',
        valueFormatter: currencyFormatter,
        type: 'rightAligned',
        comparator: (valA, valB) => {
          return valA - valB
        }
      },
    ]"
    :row-data="account.transactions"
    @grid-ready="onGridReady"
  >
  </ag-grid-vue>
</template>

<style scoped>

</style>
