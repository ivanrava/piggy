<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {Category} from "../../../composables/interfaces";
import {computed} from "vue";
import BudgetBarOverall from "./BudgetBarOverall.vue";
import BudgetBarsMonthly from "./BudgetBarsMonthly.vue";

const props = defineProps<{
  category: Category
}>();

const isMonthlyBudget = computed(() => {
  return typeof props.category.budget === 'object'
})
</script>

<template>
  <article class="p-2 flex flex-row items-center justify-between">
    <h2 class="flex flex-row gap-2 items-center">
      <Icon :icon="category.icon" />
      <span>{{ category.name }}</span>
    </h2>
    <BudgetBarsMonthly
      v-if="isMonthlyBudget"
      :category="category"
    />
    <BudgetBarOverall
      v-else
      :category="category"
    />
  </article>
  <hr class="opacity-20 border-pink-600 dark:border-pink-50">
</template>

<style scoped>

</style>
