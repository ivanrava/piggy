<script setup lang="ts">
import {computed, ref, watchEffect} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import {Beneficiary} from "../../../composables/interfaces";
import {useBeneficiariesStore} from "../../../composables/useBeneficiariesStore";
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";
import NoData from "../../../components/NoData.vue";
import ChartPie from "../../../components/stats/ChartPie.vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import BeneficiaryFormWrapper from "../../../components/form/crud/BeneficiaryFormWrapper.vue";

const route = useRoute();
const store = useBeneficiariesStore();

const isLoading = ref<Boolean>(false);
const beneficiary = ref<Beneficiary>(null);

const accounts = ref([]);
const categories = ref([]);

watchEffect(() => {
  isLoading.value = true;
  axios.get(`/beneficiaries/${route.params.id}`).then(({data}) => {
    beneficiary.value = data.data;
  }).finally(() => {
    isLoading.value = false;
  })
  axios.get(`/stats/beneficiaries/${route.params.id}/accounts`).then(({data}) => {
    accounts.value = data;
  })
  axios.get(`/stats/beneficiaries/${route.params.id}/categories`).then(({data}) => {
    categories.value = data;
  })
})

const totalTransactions = computed(() => {
  return accounts.value.reduce((previousValue, currentValue) => previousValue + currentValue.count, 0);
})
</script>

<template>
  <Transition
    name="fade-loading"
    mode="out-in"
  >
    <div v-if="isLoading">
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse" />
    </div>
    <div
      v-else
      class="flex-col my-4"
    >
      <div
        class="flex flex-col my-4"
      >
        <div class="flex items-center gap-3 mb-1">
          <h1 class="flex items-center gap-2 my-0">
            <beneficiary-image :beneficiary="beneficiary" />
            <span>
              {{ beneficiary.name }}
            </span>
          </h1>
          <a
            class="cursor-pointer flex flex-col justify-center !text-lg pt-2"
            role="button"
            @click="store.editCategory()"
          >
            <span>
              Edit
            </span>
          </a>
        </div>
        <router-link
          :to="`/beneficiaries/${beneficiary.id}/transactions`"
          class="unstyled uppercase tracking-wider text-stone-800/50 hover:text-pink-800/90 focus:font-medium transition-all"
        >
          Show transactions
        </router-link>
      </div>
    </div>
  </Transition>
  <div class="flex flex-col h-full w-full justify-between">
    <Transition
      name="fade-loading"
      mode="out-in"
    >
      <section v-if="isLoading">
        <div class="flex flex-row gap-x-2 mb-2">
          <div class="h-5 bg-gray-400 rounded-md w-64 animate-pulse" />
          <div class="h-5 bg-gray-500/70 rounded-md w-44 animate-pulse" />
        </div>
        <div class="flex flex-row gap-x-2 mb-2">
          <div class="h-5 bg-gray-500/70 rounded-md w-32 animate-pulse" />
          <div class="h-5 bg-gray-400 rounded-md w-96 animate-pulse" />
        </div>
        <div class="flex flex-row gap-x-2 mb-4">
          <div class="h-5 bg-gray-500/80 rounded-md w-24 animate-pulse" />
          <div class="h-5 bg-gray-400 rounded-md w-80 animate-pulse" />
        </div>
        <div
          class="w-full flex justify-around my-16"
          role="status"
        >
          <div class="w-1/2 max-w-sm p-4 border border-gray-500 rounded shadow animate-pulse md:p-6">
            <div class="h-2.5 bg-gray-500 rounded-full w-32 mb-2.5" />
            <div class="w-48 h-2 mb-10 bg-gray-400 rounded-full" />
            <div class="flex items-baseline mt-4 space-x-6">
              <div class="w-full bg-gray-500 rounded-t-lg h-72" />
              <div class="w-full h-56 bg-gray-500 rounded-t-lg" />
              <div class="w-full bg-gray-400 rounded-t-lg h-72" />
              <div class="w-full h-64 bg-gray-400 rounded-t-lg" />
              <div class="w-full bg-gray-500 rounded-t-lg h-80" />
              <div class="w-full bg-gray-400 rounded-t-lg h-72" />
              <div class="w-full bg-gray-500 rounded-t-lg h-80" />
            </div>
            <span class="sr-only">Loading...</span>
          </div>
          <div class="w-1/2 max-w-sm p-4 border border-gray-500 rounded shadow animate-pulse md:p-6">
            <div class="h-2.5 bg-gray-500 rounded-full w-32 mb-2.5" />
            <div class="w-48 h-2 mb-10 bg-gray-400 rounded-full" />
            <div class="flex items-baseline mt-4 space-x-6">
              <div class="w-full bg-gray-500 rounded-t-lg h-72" />
              <div class="w-full h-56 bg-gray-500 rounded-t-lg" />
              <div class="w-full bg-gray-400 rounded-t-lg h-72" />
              <div class="w-full h-64 bg-gray-400 rounded-t-lg" />
              <div class="w-full bg-gray-500 rounded-t-lg h-80" />
              <div class="w-full bg-gray-400 rounded-t-lg h-72" />
              <div class="w-full bg-gray-500 rounded-t-lg h-80" />
            </div>
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </section>
      <section v-else>
        <ul>
          <li>
            <b>Total transactions:</b>
            <span class="pl-1">
              {{ totalTransactions }}
            </span>
          </li>
          <li>
            <b>Total amount of money:</b>
            <span class="pl-1">
              {{ useAgGridUtilites().currencyFormatterBare(accounts.reduce((previousValue, currentValue) => previousValue + Number(currentValue.sum), 0)) }}
            </span>
          </li>
        </ul>
        <Transition
          mode="out-in"
          name="fade"
        >
          <section
            v-if="totalTransactions > 0"
            class="w-full flex"
          >
            <div class="w-1/2 px-16 print:p-0">
              <chart-pie
                :data="accounts"
                title="Account distribution"
                tooltip="Total of transactions"
              />
            </div>
            <div class="w-1/2 px-16 print:p-0">
              <chart-pie
                :data="categories"
                title="Category distribution"
                tooltip="Total of transactions"
              />
            </div>
          </section>
          <no-data
            v-else
            class="mt-8"
          />
        </Transition>
      </section>
    </Transition>
    <beneficiary-form-wrapper />
  </div>
</template>

<style scoped>

</style>