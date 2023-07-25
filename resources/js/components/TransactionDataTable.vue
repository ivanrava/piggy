<script setup lang="ts">
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
import "ag-grid-community/styles/ag-theme-alpine.css";
import BeneficiaryRenderer from "./renderers/BeneficiaryRenderer.vue";
import CategoryRenderer from "./renderers/CategoryRenderer.vue";
import AmountRenderer from "./renderers/AmountRenderer.vue";
import {AgGridVue} from "ag-grid-vue3";
import {computed, ref, watchEffect} from "vue";
import AccountRenderer from "./renderers/AccountRenderer.vue";
import {useOperationsStore} from "../composables/useOperationsStore";
import {useAgGridUtilites} from "../composables/useAgGridUtilities";
import {ColumnApi, GridApi} from "ag-grid-community";
import {Icon} from "@iconify/vue";

const props = defineProps<{
  fields: Array<String>
}>();

const store = useOperationsStore()
const {stringComparator, currencyFormatter, dateFormatter} = useAgGridUtilites();

const gridApi = ref<GridApi|{}>({});
const columnApi = ref<ColumnApi|{}>({});
const onGridReady = (params) => {
  gridApi.value = params.api;
  columnApi.value = params.columnApi;
}

watchEffect(() => {
  if ('setRowData' in gridApi.value) {
    gridApi.value?.setRowData(store.getOperations);
    columnApi.value.applyColumnState({
      state: [{ colId: 'date', sort: 'desc' }],
      defaultState: { sort: null },
    });
    gridApi.value.sizeColumnsToFit({defaultMinWidth: 100, defaultMaxWidth: window.innerWidth})
    gridApi.value.showLoadingOverlay();
  }
});

const fieldDefs = computed(() => {
  if (window.innerWidth <= 720) {
    return {}
  }
  return {
    account: {
      headerName: 'Account', field: 'data',
      cellRenderer: AccountRenderer,
      comparator: stringComparator
    },
    beneficiary: {
      headerName: 'Beneficiary', field: 'data',
      cellRenderer: BeneficiaryRenderer, autoHeight: true,
      cellClass: 'beneficiary-cell',
      comparator: stringComparator
    },
    category: {
      headerName: 'Category', field: 'data',
      cellRenderer: CategoryRenderer,
      comparator: stringComparator
    },
  }
})
const defaultColDefs = [
  {
    headerName: 'Date', field: 'date',
    type: window.innerWidth <= 720 ? '' : 'rightAligned',
    valueFormatter: dateFormatter,
    cellClass: 'date-cell',
    sortable: true,
    suppressSizeToFit: true,
    maxWidth: window.innerWidth <= 720 ? 120 : 200
  },
  {
    headerName: 'Amount', field: 'amount',
    type: 'rightAligned',
    valueFormatter: currencyFormatter,
    cellRenderer: AmountRenderer,
    comparator: (valA, valB) => {
      return valA - valB
    },
    cellClass: 'amount-cell',
    sortable: true
  },
];

const columnDefs = computed(() => {
  return Object.keys(fieldDefs.value)
    .filter((key) => props.fields.includes(key))
    .map((field) => fieldDefs.value[field])
    .concat(defaultColDefs)
})

const overlayLoadingTemplate = '<span class="ag-overlay-loading-center dark:text-stone-200"><Icon icon="line-md:loading-loop" />Loading transactions</span>';
const overlayNoRowsTemplate = '<span class="text-xl opacity-60">No transactions to show</span>';
</script>

<template>
  <ag-grid-vue
    class="ag-theme-material ag-theme-piggy h-4/5 w-full"
    :suppress-cell-focus="true"
    :pagination="true"
    :pagination-auto-page-size="true"
    :animate-rows="true"
    :column-defs="columnDefs"
    :row-data="store.getOperations"
    :overlay-no-rows-template="overlayNoRowsTemplate"
    :overlay-loading-template="overlayLoadingTemplate"
    @grid-ready="onGridReady"
  />
</template>

<style>
.ag-row-even {
  @apply bg-stone-100 dark:bg-stone-800/80 border-0;
}
.ag-row-odd {
  @apply bg-stone-50 dark:bg-stone-900 border-0;
}
.ag-paging-panel {
  @apply justify-around md:justify-start border-0;
}
.ag-paging-row-summary-panel span, .ag-paging-description span {
  @apply text-[10px] md:text-xs;
}
.ag-paging-row-summary-panel, .ag-paging-page-summary-panel {
  @apply ml-4 mr-0 md:my-4 dark:text-gray-200;
}
.ag-paging-button {
  @apply m-0;
}
.ag-theme-piggy {
  --ag-font-family: 'Inter', sans;
  --ag-row-hover-color: #f1f1f1;
}
@media (prefers-color-scheme: dark) {
  .ag-theme-piggy {
    --ag-header-cell-hover-background-color: #333333;
    --ag-row-hover-color: #33333344;
    --ag-disabled-foreground-color: #444;
    --ag-modal-overlay-background-color: #222222ee;
    --ag-background-color: #333;
  }
}
.amount-cell {
  @apply md:text-[1.2rem] text-base text-center md:text-left;
}
.date-cell {
  @apply text-left md:text-right ml-4 md:m-0 text-[0.85rem] dark:text-gray-200;
}
.ag-header-cell-label {
  @apply md:text-[1.2rem] text-sm leading-5 md:leading-5 text-center ml-4 md:m-0 dark:text-gray-100;
}
.ag-header-cell:nth-child(2) .ag-header-cell-label {
  @apply justify-center md:justify-start;
}
.beneficiary-cell {
  @apply md:px-0;
}
.ag-header-cell:first-child {
  @apply md:px-6;
}
.ag-header-cell {
  @apply px-2 md:px-4 dark:bg-stone-900;
}
.ag-cell-value {
  @apply px-2 md:px-4;
}
.beneficiary-cell .ag-cell-value {
  @apply grow-0;
}
.ag-root-wrapper {
  @apply dark:bg-stone-900 text-gray-100;
}
</style>
