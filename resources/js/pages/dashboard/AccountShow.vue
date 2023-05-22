<script setup lang="ts">
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
import {computed, onMounted, ref, watchEffect} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import {AgGridVue} from "ag-grid-vue3";
import BeneficiaryRenderer from "../../components/renderers/BeneficiaryRenderer.vue";
import CategoryRenderer from "../../components/renderers/CategoryRenderer.vue";
import AmountRenderer from "../../components/renderers/AmountRenderer.vue";
import TransactionForm from "../../components/form/crud/TransactionForm.vue";
import {Account} from "../../composables/interfaces";
const route = useRoute();

const account = ref<Account>(null);
const errors = ref([]);
onMounted(() => {
  axios.get("/accounts/"+route.params.id).then(({data}) => {
    account.value = data.data;
    columnApi.value.applyColumnState({
      state: [{ colId: 'date', sort: 'desc' }],
      defaultState: { sort: null },
    });
    gridApi.value.sizeColumnsToFit({
      defaultMinWidth: 100,
    })
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
const columnApi = ref({});
const onGridReady = (params) => {
  gridApi.value = params.api;
  columnApi.value = params.columnApi;
}

const stringComparator = (valA, valB) => {
  if (valA.name == valB.name)
    return 0;
  return (valA.name > valB.name) ? 1 : -1;
}

const transactions = computed(() => {
  if (account.value !== null) {
    const transfers = account.value.in_transfers.concat(account.value.out_transfers);
    return account.value.transactions.concat(transfers)
  }
  return [];
})

const addedTransactions = ref([]);
watchEffect(() => {
  if ('setRowData' in gridApi.value) {
    gridApi.value?.setRowData(transactions.value.concat(addedTransactions.value));
  }
});
</script>

<template>
  <h1 v-if="account">
    {{ account.name }} transactions
  </h1>
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
  <transaction-form
    v-if="account"
    :account-id="account.id"
    @added="(trans) => addedTransactions.push(trans)"
  />
</template>

<style>
.ag-theme-piggy {
  --ag-font-family: 'Inter', sans;
}
.amount-cell {
  font-size: 1.2rem;
}
.date-cell {
  @apply text-right;
  font-size: 0.8rem;
}
.ag-header-cell-label {
  font-size: 1.2rem;
}
</style>
