<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionForm from "../../components/form/crud/TransactionForm.vue";
import {Account} from "../../composables/interfaces";
import TransactionDataTable from "../../components/TransactionDataTable.vue";
import {useOperationsStore} from "../../composables/useOperationsStore";

const route = useRoute();
const store = useOperationsStore();

const account = ref<Account>(null);
const errors = ref([]);
onMounted(() => {
  axios.get(`/accounts/${route.params.id}`).then(({data}) => {
    account.value = data.data;
    store.setOperations(
      account.value.transactions,
      account.value.in_transfers,
      account.value.out_transfers
    );
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
</script>

<template>
  <Transition
    name="fade-loading"
    mode="out-in"
  >
    <div v-if="account == null">
      <div class="h-10 bg-gray-400 rounded-md w-96 my-4 animate-pulse" />
      <div class="flex flex-row gap-x-2 mb-2">
        <div class="h-5 bg-gray-400 rounded-md w-80 animate-pulse" />
        <div class="h-5 bg-gray-500/70 rounded-md w-44 animate-pulse" />
        <div class="h-5 bg-gray-400/90 rounded-md w-52 animate-pulse" />
        <div class="h-5 bg-gray-500/70 rounded-md w-40 animate-pulse" />
        <div class="h-5 bg-gray-400 rounded-md w-72 animate-pulse" />
      </div>
      <div class="flex flex-row gap-x-2 mb-4">
        <div class="h-5 bg-gray-500/70 rounded-md w-32 animate-pulse" />
        <div class="h-5 bg-gray-400 rounded-md w-96 animate-pulse" />
      </div>
    </div>
    <div v-else>
      <h1>
        {{ account.name }} transactions
      </h1>
      <p class="my-4 text-stone-800">
        {{ account.description }}
      </p>
    </div>
  </Transition>
  <transaction-data-table :fields="['beneficiary', 'category']" />
  <transaction-form
    v-if="account"
    :account-id="account.id"
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
