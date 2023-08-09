<script setup lang="ts">
import {Category} from "../../../composables/interfaces";
import MonthBar from "./MonthBar.vue";

defineProps<{
  category: Category
}>();
</script>

<template>
  <aside class="w-2/3 flex flex-row justify-between">
    <MonthBar
      month="January"
      :budget="category.budget.jan"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.jan"
    />
    <MonthBar
      month="February"
      :budget="category.budget.feb"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.feb"
    />
    <MonthBar
      month="March"
      :budget="category.budget.mar"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.mar"
    />
    <MonthBar
      month="April"
      :budget="category.budget.apr"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.apr"
    />
    <MonthBar
      month="May"
      :budget="category.budget.may"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.may"
    />
    <MonthBar
      month="June"
      :budget="category.budget.jun"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.jun"
    />
    <MonthBar
      month="July"
      :budget="category.budget.jul"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.jul"
    />
    <MonthBar
      month="August"
      :budget="category.budget.aug"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.aug"
    />
    <MonthBar
      month="September"
      :budget="category.budget.sep"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.sep"
    />
    <MonthBar
      month="October"
      :budget="category.budget.oct"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.oct"
    />
    <MonthBar
      month="November"
      :budget="category.budget.nov"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.nov"
    />
    <MonthBar
      month="December"
      :budget="category.budget.dec"
      :is-out="category.type === 'out'"
      :expenditure="category.expenditures.dec"
    />
  </aside>
</template>

<style scoped>

</style>
