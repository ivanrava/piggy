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
        <category-pies
          v-if="totalTransactions > 0"
          :accounts="accounts"
          :beneficiaries="beneficiaries"
          :category="store.selectedCategory"
        />
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

const store = useCategoriesStore()

const accounts = ref([]);
const beneficiaries = ref([]);
watchEffect(() => {
  if (store.selectedCategory == null)
    return

  axios.get(`/categories/${store.selectedCategory.id}`).then(({data}) => {
    accounts.value = data.accounts;
    beneficiaries.value = data.beneficiaries;
  })
})

const totalTransactions = computed(() => {
  return accounts.value.reduce((previousValue, currentValue) => previousValue + currentValue.count, 0);
})
</script>

<style scoped>

</style>
