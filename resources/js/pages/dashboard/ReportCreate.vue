<script setup lang="ts">
import {ref} from "vue";
import axios from "axios";
import {Category} from "../../composables/interfaces";
import TrReportCategory from "../../components/TrReportCategory.vue";
import {useAgGridUtilites} from "../../composables/useAgGridUtilities";
import FormInput from "../../components/form/inputs/FormInput.vue";
import SubmitButton from "../../components/form/inputs/SubmitButton.vue";

const form = ref({
  from: '',
  to: ''
})
const inCategories = ref<Array<Category>>([]);
const outCategories = ref<Array<Category>>([]);
const fetched = ref(false);
const fetchReport = (form) => {
  axios.get('/report', {
    params: {
      from: form.from,
      to: form.to,
    }
  }).then(({data}) => {
    inCategories.value = data.in
    outCategories.value = data.out
    fetched.value = true;
  })
}

const sumCategories = (categories) => {
  return categories.reduce((previousValue, currentValue) => previousValue + currentValue.transactions_sum_amount, 0)
}
const formatCurrency = (num) => {
  return useAgGridUtilites().currencyFormatterBare(num)
}
</script>

<template>
  <h1 class="print:hidden">
    Report by categories
  </h1>
  <form
    class="bg-stone-100 p-4 rounded-lg my-4 shadow-sm print:hidden"
    @submit.prevent="fetchReport(form)"
  >
    <h2>Customize your report</h2>
    <div class="flex justify-start gap-8">
      <form-input
        v-model="form.from"
        label="From"
        type="date"
      />
      <form-input
        v-model="form.to"
        label="To"
        type="date"
      />
      <submit-button>
        Submit
      </submit-button>
    </div>
  </form>
  <table
    v-if="fetched"
    class="w-full"
  >
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
  <div
    v-else
    class="flex flex-col items-center gap-8 justify-center w-full p-8 my-16"
  >
    <img
      class="w-1/3"
      src="/investment.svg"
      alt="No data"
    >
    <span class="block text-stone-600">
      Your report will be loaded right here. Fill the form and it will <i class="tracking-widest">automagically</i> appear.
    </span>
  </div>
</template>

<style scoped>

</style>
