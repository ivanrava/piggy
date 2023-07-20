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
          <div class="flex items-center gap-3 mb-1">
            <h1 class="flex items-center gap-2 my-0">
              <Icon :icon="store.selectedCategory.icon" />
              <span>
                {{ store.selectedCategory.name }}
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
            :to="`/categories/${store.selectedCategory.id}/transactions`"
            class="unstyled uppercase tracking-wider text-stone-800/50 hover:text-pink-800/90 focus:font-medium transition-all"
          >
            Show transactions
          </router-link>
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
                <b>Category type:</b>
                <span v-if="store.selectedCategory.type == 'out'">
                  Expense
                </span>
                <span v-else>
                  Income
                </span>
              </li>
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
                v-if="!isLoading && totalTransactions > 0"
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
                    :data="beneficiaries"
                    title="Beneficiary distribution"
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
    <category-form />
  </div>
</template>

<script setup lang="ts">
import CategoryForm from "../../../components/form/crud/CategoryFormWrapper.vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";
import {Icon} from "@iconify/vue";
import {computed, watchEffect} from "vue";
import axios from "axios";
import {ref} from "vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import NoData from "../../../components/NoData.vue";
import {useRoute} from "vue-router";
import {Category} from "../../../composables/interfaces";
import ChartPie from "../../../components/stats/ChartPie.vue";
import GraphSkeleton from "../../../components/GraphSkeleton.vue";

const store = useCategoriesStore()
const route = useRoute();

const accounts = ref([]);
const beneficiaries = ref([]);
const category = ref<Category>(null);
const isLoading = ref(false);
watchEffect(() => {
  isLoading.value = true;
  axios.get(`/categories/${route.params.id}`).then(({data}) => {
    category.value = data.data;
    store.selectCategory(category.value);
  }).finally(() => {
    isLoading.value = false;
  })
  axios.get(`/stats/categories/${route.params.id}/accounts`).then(({data}) => {
    accounts.value = data;
  });
  axios.get(`/stats/categories/${route.params.id}/beneficiaries`).then(({data}) => {
    beneficiaries.value = data;
  })
})

const totalTransactions = computed(() => {
  return accounts.value.reduce((previousValue, currentValue) => previousValue + currentValue.count, 0);
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
