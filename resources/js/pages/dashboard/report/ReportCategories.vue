<script setup lang="ts">
import TrReportCategory from "./TrReportCategory.vue";
import {Category} from "../../../composables/interfaces";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {useReportFunctions} from "../../../composables/useReportFunctions";

defineProps<{
  inCategories: Array<Category>,
  outCategories: Array<Category>,
}>()

const formatCurrency = (num) => {
  return useAgGridUtilites().currencyFormatterBare(num)
}
const budgetFor = (rootCategory: Category) => {
  if (rootCategory.children.length == 0)
    return 0
  return rootCategory.children.reduce((acc, currCat) => acc + useReportFunctions().budgetSum(currCat), 0)
}
const offsetFor = (rootCategory: Category) => {
  if (rootCategory.children.length == 0)
    return 0
  return rootCategory.children.reduce((acc, currCat) => acc + useReportFunctions().offsetForChildCategory(currCat), 0)
}
const sumCategories = (categories) => {
  return categories.reduce((previousValue, currRoot) => previousValue + currRoot.transactions_sum_amount, 0)
}
const sumBudgets = (categories: Array<Category>) => {
  return categories.reduce((acc, currCat) => acc+budgetFor(currCat), 0)
}
const sumOffsets = (categories: Array<Category>) => {
  return categories.reduce((acc, currCat) => acc+offsetFor(currCat), 0)
}
const sumVirtualCategories = (categories: Array<Category>) => {
  return categories.reduce((previousValue, currRoot) => previousValue + (currRoot.children.length == 0 ? 0 : currRoot.children.reduce(
    (p, currChild) => {
      return p + (currChild.virtual ? currChild.transactions_sum_amount : 0);
    }, 0)
  ), 0)
}
const sumVirtualBudgets = (categories: Array<Category>) => {
  return categories.reduce((previousValue, currRoot) => previousValue + (currRoot.children.length == 0 ? 0 : currRoot.children.reduce(
    (previousValue, currChild) => {
      return previousValue + (currChild.virtual ? useReportFunctions().budgetSum(currChild) : 0);
    }, 0)
  ), 0)
}
const sumVirtualOffsets = (categories: Array<Category>) => {
  return categories.reduce((previousValue, currRoot) => previousValue + (currRoot.children.length == 0 ? 0 : currRoot.children.reduce(
    (previousValue, currChild) => {
      return previousValue + (currChild.virtual ? useReportFunctions().offsetForChildCategory(currChild) : 0);
    }, 0)
  ), 0)
}
</script>

<template>
  <table class="w-full">
    <thead class="text-blue-900 dark:text-blue-300/70">
      <tr class="border-b-2 border-black text-2xl dark:border-stone-400/30">
        <th class="w-3/6 text-left">
          Category
        </th>
        <th class="w-1/6 text-right">
          Total
        </th>
        <th class="w-1/6 text-right">
          Budget
        </th>
        <th class="w-1/6 text-right">
          Offset
        </th>
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
        <th class="text-right pt-6">
          {{ formatCurrency(sumBudgets(inCategories)) }}
        </th>
        <th class="text-right pt-6">
          {{ formatCurrency(sumOffsets(inCategories)) }}
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
        <th class="text-right pt-6">
          {{ formatCurrency(sumBudgets(outCategories)) }}
        </th>
        <th class="text-right pt-6">
          {{ formatCurrency(sumOffsets(outCategories)) }}
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
        <th class="text-right pt-2">
          {{ formatCurrency(sumBudgets(inCategories)) }}
        </th>
        <th class="text-right pt-2">
          {{ formatCurrency(sumOffsets(inCategories)) }}
        </th>
      </tr>
      <tr>
        <th class="text-left text-lg">
          Of which virtual
        </th>
        <th class="text-right">
          {{ formatCurrency(sumVirtualCategories(inCategories)) }}
        </th>
        <th class="text-right">
          {{ formatCurrency(sumVirtualBudgets(inCategories)) }}
        </th>
        <th class="text-right">
          {{ formatCurrency(sumVirtualOffsets(inCategories)) }}
        </th>
      </tr>
      <tr>
        <th class="text-left text-lg">
          Total expenses
        </th>
        <th class="text-right">
          {{ formatCurrency(-sumCategories(outCategories)) }}
        </th>
        <th class="text-right">
          {{ formatCurrency(-sumBudgets(outCategories)) }}
        </th>
        <th class="text-right">
          {{ formatCurrency(sumOffsets(outCategories)) }}
        </th>
      </tr>
      <tr>
        <th class="text-left pb-2 text-lg">
          Of which virtual
        </th>
        <th class="text-right pb-2">
          {{ formatCurrency(-sumVirtualCategories(outCategories)) }}
        </th>
        <th class="text-right pb-2">
          {{ formatCurrency(-sumVirtualBudgets(outCategories)) }}
        </th>
        <th class="text-right pb-2">
          {{ formatCurrency(sumVirtualOffsets(outCategories)) }}
        </th>
      </tr>
      <tr class="border-t-2 border-dashed border-stone-500">
        <th class="text-left text-xl py-2">
          Final balance
        </th>
        <th class="text-right py-2">
          {{ formatCurrency(sumCategories(inCategories) - sumCategories(outCategories)) }}
        </th>
        <th class="text-right py-2">
          {{ formatCurrency(sumBudgets(inCategories) - sumBudgets(outCategories)) }}
        </th>
        <th class="text-right py-2">
          {{ formatCurrency(sumOffsets(inCategories) + sumOffsets(outCategories)) }}
        </th>
      </tr>
      <tr class="border-t-2 border-dashed border-stone-500">
        <th class="text-left text-xl pt-2">
          Real balance
        </th>
        <th class="text-right pt-2">
          {{ formatCurrency(sumCategories(inCategories) - sumVirtualCategories(inCategories) - sumCategories(outCategories) + sumVirtualCategories(outCategories)) }}
        </th>
        <th class="text-right pt-2">
          {{ formatCurrency(sumBudgets(inCategories) - sumVirtualBudgets(inCategories) - sumBudgets(outCategories) + sumVirtualBudgets(outCategories)) }}
        </th>
        <th class="text-right pt-2">
          {{ formatCurrency(sumOffsets(inCategories) - sumVirtualOffsets(inCategories) + sumOffsets(outCategories) - sumVirtualOffsets(outCategories)) }}
        </th>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>

</style>
