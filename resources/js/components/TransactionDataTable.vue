<script setup lang="ts">
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
import BeneficiaryRenderer from "./renderers/BeneficiaryRenderer.vue";
import CategoryRenderer from "./renderers/CategoryRenderer.vue";
import AmountRenderer from "./renderers/AmountRenderer.vue";
import {AgGridVue} from "ag-grid-vue3";
import {ref, watchEffect} from "vue";
import {Transaction} from "../composables/interfaces";

const props = defineProps<{
  transactions: Array<Transaction>
}>();

const stringComparator = (valA, valB) => {
  if (valA.name == valB.name)
    return 0;
  return (valA.name > valB.name) ? 1 : -1;
}
const dateFormatter = (date) => {
  return (new Date(date.value)).toLocaleDateString(undefined, {weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'})
}
const currencyFormatter = (curr) => {
  return curr.value.toString() + ' €'
}

const gridApi = ref({});
const columnApi = ref({});
const onGridReady = (params) => {
  gridApi.value = params.api;
  columnApi.value = params.columnApi;
}

watchEffect(() => {
  if ('setRowData' in gridApi.value) {
    gridApi.value?.setRowData(props.transactions);
    columnApi.value.applyColumnState({
      state: [{ colId: 'date', sort: 'desc' }],
      defaultState: { sort: null },
    });
    gridApi.value.sizeColumnsToFit({
      defaultMinWidth: 100,
    })
  }
});
</script>

<template>
  <ag-grid-vue
    class="ag-theme-material ag-theme-piggy h-4/5 w-full"
    :suppress-cell-focus="true"
    :pagination="true"
    :pagination-auto-page-size="true"
    :animate-rows="true"
    :column-defs="[
      {
        headerName: 'Beneficiary', field: 'data',
        cellRenderer: BeneficiaryRenderer, autoHeight: true,
        comparator: stringComparator
      },
      {
        headerName: 'Category', field: 'data',
        cellRenderer: CategoryRenderer,
        comparator: stringComparator
      },
      {
        headerName: 'Date', field: 'date',
        type: 'rightAligned',
        valueFormatter: dateFormatter,
        cellClass: 'date-cell',
        sortable: true
      },
      {
        headerName: 'Amount', field: 'amount',
        valueFormatter: currencyFormatter,
        cellRenderer: AmountRenderer,
        comparator: (valA, valB) => {
          return valA - valB
        },
        cellClass: 'amount-cell',
        sortable: true
      },
    ]"
    :row-data="transactions"
    @grid-ready="onGridReady"
  />
</template>

<style scoped>

</style>
