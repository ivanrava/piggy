<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionDataTable from "../../../components/TransactionDataTable.vue";
import {Beneficiary} from "../../../composables/interfaces";
import {useOperationsStore} from "../../../composables/useOperationsStore";
import {Icon} from "@iconify/vue";

const beneficiary = ref<Beneficiary>(null);
const store = useOperationsStore();

const errors = ref({});
onMounted(() => {
  store.setOperations([], [], []);
  axios.get("/beneficiaries/"+useRoute().params.id).then(({data}) => {
    beneficiary.value = data.data;
    store.setOperations(beneficiary.value.transactions, [], [])
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
    <div v-if="beneficiary == null">
      <div class="h-6 bg-gray-400 rounded-md w-96 mb-4 my-3 animate-pulse" />
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse" />
    </div>
    <div
      v-else
      class="flex flex-col my-4"
    >
      <router-link
        :to="`/beneficiaries/${beneficiary.id}`"
        class="unstyled uppercase tracking-wider text-pink-800/50 hover:text-pink-800/90 focus:font-medium transition-all flex gap-2 items-center"
      >
        <Icon icon="pajamas:go-back" />
        Back to the beneficiary details
      </router-link>
      <h1 class="my-1">
        Transactions under {{ beneficiary.name }}
      </h1>
    </div>
  </Transition>
  <transaction-data-table :fields="['account', 'category']" />
</template>

<style scoped>

</style>
