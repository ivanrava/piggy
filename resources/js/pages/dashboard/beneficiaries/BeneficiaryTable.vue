<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionDataTable from "../../../components/TransactionDataTable.vue";
import {Beneficiary} from "../../../composables/interfaces";
import {useOperationsStore} from "../../../composables/useOperationsStore";
import {Icon} from "@iconify/vue";
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";

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
      class="flex w-full justify-between"
    >
      <div
        class="flex flex-col my-4"
      >
        <router-link
          :to="`/beneficiaries/${beneficiary.id}`"
          class="unstyled uppercase tracking-wider text-stone-800/50 hover:text-pink-800/90 focus:font-medium transition-all flex gap-2 items-center"
        >
          <Icon icon="pajamas:go-back" />
          Back to the beneficiary details
        </router-link>
        <h1 class="my-1">
          Transactions under {{ beneficiary.name }}
        </h1>
      </div>
      <div class="flex flex-col justify-center">
        <div class="flex flex-row-reverse gap-2 bg-slate-50 py-1 pl-4 pr-2 rounded-xl items-center shadow-sm justify-start">
          <beneficiary-image
            :beneficiary="beneficiary"
            class="!h-20 !w-20"
          />
          <div class="flex flex-col justify-center items-end">
            <h2 class="font-semibold my-0 text-xl">
              {{ beneficiary.name }}
            </h2>
            <span class="text-2xl font-extralight tracking-tight">
              {{ useAgGridUtilites().currencyFormatterBare(store.getTotal()) }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </Transition>
  <transaction-data-table :fields="['account', 'category']" />
</template>

<style scoped>

</style>
