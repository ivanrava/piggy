<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionForm from "../../components/form/crud/TransactionForm.vue";
import {Account} from "../../composables/interfaces";
import TransactionDataTable from "../../components/TransactionDataTable.vue";
const route = useRoute();

const account = ref<Account>(null);
const errors = ref([]);
onMounted(() => {
  axios.get("/accounts/"+route.params.id).then(({data}) => {
    account.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});

const addedTransactions = ref([]);

const transactions = computed(() => {
  if (account.value !== null) {
    const transfers = account.value.in_transfers.concat(account.value.out_transfers);
    return account.value.transactions.concat(transfers).concat(addedTransactions.value)
  }
  return [];
})
</script>

<template>
  <Transition
    name="fade-loading"
    mode="out-in"
  >
    <div v-if="account == null">
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse" />
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
  <transaction-data-table
    :transactions="transactions"
    :fields="['beneficiary', 'category']"
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
