<template>
  <h1 v-if="store.selectedCategory == null">
    No category selected
  </h1>
  <h1
    v-else
    class="flex gap-2"
  >
    <Icon :icon="store.selectedCategory.icon" />
    <span>
      {{ store.selectedCategory.name }}
    </span>
  </h1>
  <div class="flex flex-col h-full w-full justify-between">
    <Transition
      name="fade-loading"
      mode="out-in"
    >
      <section v-if="store.selectedCategory != null">
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
          <category-pies
            v-if="!isLoading && totalTransactions > 0"
            :accounts="accounts"
            :beneficiaries="beneficiaries"
            :category="store.selectedCategory"
          />
          <div
            v-else-if="isLoading"
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
          <no-data
            v-else
            class="mt-8"
          />
        </Transition>
      </section>
      <div
        v-else
        class="flex flex-col items-center gap-8 justify-center w-full p-8 my-16"
      >
        <img
          class="w-1/3"
          src="/investing.svg"
          alt="No data"
        >
        <span class="block text-stone-600">
          We will load data from your categories in here, please click one of the categories on the sidebar.
        </span>
      </div>
    </Transition>
    <category-form />
  </div>
</template>

<script setup lang="ts">
import CategoryForm from "../../components/form/crud/CategoryFormWrapper.vue";
import {useCategoriesStore} from "../../composables/useCategoriesStore";
import {Icon} from "@iconify/vue";
import CategoryPies from "./stats/CategoryPies.vue";
import {computed, watchEffect} from "vue";
import axios from "axios";
import {ref} from "vue";
import {useAgGridUtilites} from "../../composables/useAgGridUtilities";
import NoData from "../../components/NoData.vue";

const store = useCategoriesStore()

const accounts = ref([]);
const beneficiaries = ref([]);
const isLoading = ref(false);
watchEffect(() => {
  if (store.selectedCategory == null)
    return

  isLoading.value = true;
  axios.get(`/categories/${store.selectedCategory.id}`).then(({data}) => {
    accounts.value = data.accounts;
    beneficiaries.value = data.beneficiaries;
  }).finally(() => {
    isLoading.value = false;
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
