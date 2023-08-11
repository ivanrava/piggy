<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {Category} from "../../../composables/interfaces";
import {computed} from "vue";
import BudgetBarOverall from "./BudgetBarOverall.vue";
import BudgetBarsMonthly from "./BudgetBarsMonthly.vue";
import ActionLink from "../../../components/ActionLink.vue";

const props = defineProps<{
  category: Category
}>();

const isMonthlyBudget = computed(() => {
  return typeof props.category.budget === 'object'
})

defineEmits(['edit']);
</script>

<template>
  <article class="p-2 flex flex-row items-center justify-between">
    <div class="flex flex-col py-2">
      <h3
        class="flex flex-row gap-2 items-center my-0 font-extralight"
        :class="category.type === 'out' ? 'dark:text-pink-200 text-pink-700' : 'dark:text-green-200/50 text-green-700'"
      >
        <Icon :icon="category.parent.icon" />
        <span>{{ category.parent.name }}</span>
      </h3>
      <h2 class="flex flex-row gap-2 items-center my-0 font-light">
        <Icon :icon="category.icon" />
        <span>{{ category.name }}</span>
      </h2>
      <ActionLink
        class="mt-4"
        @click="$emit('edit', category)"
      >
        Edit budget
      </ActionLink>
    </div>
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
