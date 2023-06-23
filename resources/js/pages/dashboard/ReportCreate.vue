<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {Category} from "../../composables/interfaces";
import TrReportCategory from "../../components/TrReportCategory.vue";


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
</script>

<template>
  <form />
  <table class="w-full">
    <thead>
      <tr class="border-b-2 border-black">
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
          class="text-left pt-4"
        >
          Income categories
        </th>
      </tr>
      <tr-report-category
        v-for="c in inCategories"
        :key="c.name"
        :category="c"
      />
      <tr class="border-b-2 border-black">
        <th
          colspan="2"
          class="text-left pt-4"
        >
          Expense categories
        </th>
      </tr>
      <tr-report-category
        v-for="c in outCategories"
        :key="c.name"
        :category="c"
      />
    </tbody>
  </table>
</template>

<style scoped>

</style>
