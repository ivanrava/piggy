<script setup lang="ts">
import TrReportCategory from "./TrReportCategory.vue";
import {Category} from "../../../composables/interfaces";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";

defineProps<{
  inCategories: Array<Category>,
  outCategories: Array<Category>,
}>()

const sumCategories = (categories) => {
  return categories.reduce((previousValue, currentValue) => previousValue + currentValue.transactions_sum_amount, 0)
}
const formatCurrency = (num) => {
  return useAgGridUtilites().currencyFormatterBare(num)
}
</script>

<template>
  <table
    class="w-full"
  >
    <thead class="text-blue-900 dark:text-blue-300/70">
      <tr class="border-b-2 border-black text-2xl dark:border-stone-400/30">
        <th class="w-3/6 text-left">
          Category
        </th>
        <th class="w-3/6 text-right">
          Total
        </th>
<!--        <th class="w-1/6 text-right" />-->
<!--        <th class="w-1/6 text-right" />-->
      </tr>
    </thead>
    <tbody>
      <tr class="border-b-2 border-black dark:border-stone-400/30">
        <th
          colspan="2"
          class="text-left pt-4 text-blue-900 dark:text-blue-300/70 text-xl"
        >
          Income categories
        </th>
      </tr>
      <tr-report-category
        v-for="c in inCategories"
        :key="c.name"
        :category="c"
      />
      <tr>
        <th class="text-left pt-6 text-lg">
          Total incomes
        </th>
        <th class="text-right pt-6">
          {{ formatCurrency(sumCategories(inCategories)) }}
        </th>
      </tr>
      <tr class="border-b-2 border-black dark:border-stone-400/30">
        <th
          colspan="2"
          class="text-left pt-4 text-blue-900 dark:text-blue-300/70 text-xl"
        >
          Expense categories
        </th>
      </tr>
      <tr-report-category
        v-for="c in outCategories"
        :key="c.name"
        :category="c"
      />
      <tr>
        <th class="text-left pt-6 text-lg">
          Total expenses
        </th>
        <th class="text-right pt-6">
          {{ formatCurrency(sumCategories(outCategories)) }}
        </th>
      </tr>
      <tr class="border-b-2 border-black text-left text-xl text-blue-900 dark:text-blue-300/70 dark:border-stone-400/30">
        <th class="pt-4">
          Summary
        </th>
      </tr>
      <tr>
        <th class="text-left pt-2 text-lg">
          Total incomes
        </th>
        <th class="text-right pt-2">
          {{ formatCurrency(sumCategories(inCategories)) }}
        </th>
      </tr>
      <tr>
        <th class="text-left pb-2 text-lg">
          Total expenses
        </th>
        <th class="text-right pb-2">
          {{ formatCurrency(-sumCategories(outCategories)) }}
        </th>
      </tr>
      <tr class="border-t-2 border-dashed border-stone-500">
        <th class="text-left text-xl pt-2">
          Final balance
        </th>
        <th class="text-right pt-2">
          {{ formatCurrency(sumCategories(inCategories) - sumCategories(outCategories)) }}
        </th>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>

</style>
