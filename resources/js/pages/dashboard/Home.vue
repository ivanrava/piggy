<template>
  <div class="flex flex-col">
    <h1>Welcome back, {{ user.name }}</h1>
    <h2 class="mb-4">
      Favorite charts
    </h2>
    <div
      v-if="charts.length === 0"
      class="flex flex-col items-center gap-8 justify-center w-full bg-stone-100 rounded-xl p-8"
    >
      <img
        class="w-1/5"
        src="/setup_analytics.svg"
        alt="No data"
      >
      <small class="block text-stone-600">You do not have any graph view setup. Please consider adding one here.</small>
    </div>
    <div
      v-else
      class="flex flex-row gap-4"
    >
      <generic-chart-wrapper
        v-for="chartForm in charts.slice(0,4)"
        :key="chartForm.id"
        class="!m-0"
        :form="chartForm"
      />
    </div>
    <div class="flex flex-col justify-between h-full">
      <section>
        <h2 class="my-4">
          Accounts
        </h2>
        <Transition
          name="fade-loading"
          mode="out-in"
        >
          <div
            v-if="isLoading"
            role="status"
          >
            <div class="flex flex-wrap items-center w-full gap-4">
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-40" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-40" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-40" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-24" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-24" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-42" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
              <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80" />
              <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            </div>
            <span class="sr-only">Loading...</span>
          </div>
          <div v-else-if="store.accounts.length === 0">
            <no-data />
          </div>
          <div
            v-else
            class="flex flex-wrap gap-4"
          >
            <account-card
              v-for="account in store.accounts"
              :key="account"
              :account="account"
            />
          </div>
        </Transition>
      </section>
    </div>
  </div>
</template>

<script setup>
import {useAuth} from "../../composables/useAuth";
import {onMounted, ref} from "vue";
import axios from "axios";
import GenericChartWrapper from "./stats/GenericChartWrapper.vue";
import NoData from "../../components/NoData.vue";
import AccountCard from "../../components/AccountCard.vue";
import {useAccountsStore} from "../../composables/useAccountsStore";

const {user} = useAuth();
const store = useAccountsStore();

const charts = ref([]);
const isLoading = ref(false);
onMounted(() => {
  isLoading.value = true;
  axios.get('/charts/favorites')
    .then(({data}) => {
      charts.value = data.data;
    }).finally(() => {
    isLoading.value = false;
  })
})
onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/accounts');
    store.setAccounts((await res).data.data);
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
})
</script>

<style scoped>

</style>
