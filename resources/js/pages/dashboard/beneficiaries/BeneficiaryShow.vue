<script setup lang="ts">
import {computed, ref, watchEffect} from "vue";
import axios, {AxiosError} from "axios";
import {useRoute, useRouter} from "vue-router";
import {Beneficiary} from "../../../composables/interfaces";
import {useBeneficiariesStore} from "../../../composables/useBeneficiariesStore";
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";
import NoData from "../../../components/NoData.vue";
import ChartPie from "../../../components/stats/ChartPie.vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import BeneficiaryFormWrapper from "../../../components/form/crud/BeneficiaryFormWrapper.vue";
import GraphSkeleton from "../../../components/GraphSkeleton.vue";
import ActionLink from "../../../components/ActionLink.vue";

const route = useRoute();
const router = useRouter();
const store = useBeneficiariesStore();

const isLoading = ref<Boolean>(false);
const beneficiary = ref<Beneficiary>(null);

const accounts = ref([]);
const categories = ref([]);

watchEffect(() => {
  isLoading.value = true;
  axios.get(`/beneficiaries/${route.params.id}`).then(({data}) => {
    beneficiary.value = data.data;
  }).catch((reason: AxiosError) => {
    if (reason.response.status === 404) {
      router.replace('/404')
    }
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
  <div class="h-full flex flex-col justify-between">
    <section class="overflow-scroll flex-grow">
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
              <beneficiary-image :beneficiary="beneficiary" />
              <h1 class="flex items-baseline gap-2 my-0">
                <span>
                  {{ beneficiary.name }}
                </span>
                <ActionLink @click="store.editBeneficiary(beneficiary)">
                  Edit
                </ActionLink>
              </h1>
            </div>
            <router-link
              :to="`/beneficiaries/${beneficiary.id}/transactions`"
              class="unstyled uppercase tracking-wider text-stone-800/50 hover:text-pink-800/90 dark:text-stone-100/20 dark:hover:text-pink-100/90 focus:font-medium transition-all"
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
              class="w-full flex justify-around my-16 flex-col md:flex-row"
              role="status"
            >
              <graph-skeleton />
              <graph-skeleton />
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
                class="w-full flex flex-col md:flex-row"
              >
                <div class="md:w-1/2 md:px-16 print:p-0">
                  <chart-pie
                    :data="accounts"
                    title="Account distribution"
                    tooltip="Total import of transactions"
                  />
                </div>
                <div class="md:w-1/2 md:px-16 print:p-0">
                  <chart-pie
                    :data="categories"
                    title="Category distribution"
                    tooltip="Total import of transactions"
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
      </div>
    </section>
    <beneficiary-form-wrapper @update="beneficiary = $event;" />
  </div>
</template>

<style scoped>

</style>
