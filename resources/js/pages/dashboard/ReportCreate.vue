<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {Category} from "../../composables/interfaces";
import TrReportCategory from "../../components/TrReportCategory.vue";
import {useAgGridUtilites} from "../../composables/useAgGridUtilities";


const inCategories = ref<Array<Category>>([]);
const outCategories = ref<Array<Category>>([]);
onMounted(() => {
  axios.get('/report', {
    params: {
      from: '2000-01-01',
      to: '2023-01-01',
      sort: 'amount',
      direction: 'desc'
    }
  }).then(({data}) => {
    inCategories.value = data.in
    outCategories.value = data.out
  })
})

const sumCategories = (categories) => {
  return categories.reduce((previousValue, currentValue) => previousValue + currentValue.transactions_sum_amount, 0)
}
const formatCurrency = (num) => {
  return useAgGridUtilites().currencyFormatterBare(num)
}
</script>

<template>
  <form />
  <table class="w-full">
    <thead class="text-blue-900">
      <tr class="border-b-2 border-black text-2xl">
        <th class="w-3/6 text-left">
          Category
        </th>
        <th class="w-1/6 text-right">
          Total
        </th>
        <th class="w-1/6 text-right" />
        <th class="w-1/6 text-right" />
      </tr>
    </thead>
    <tbody>
      <tr class="border-b-2 border-black">
        <th
          colspan="2"
          class="text-left pt-4 text-blue-900 text-xl"
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
      <tr class="border-b-2 border-black">
        <th
          colspan="2"
          class="text-left pt-4 text-blue-900 text-xl"
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
      <tr class="border-b-2 border-black text-left text-xl text-blue-900">
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
