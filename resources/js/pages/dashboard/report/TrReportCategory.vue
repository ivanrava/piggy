<script setup lang="ts">
import {Category} from "../../../composables/interfaces";
import {Icon} from "@iconify/vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {computed} from "vue";
import {useReportFunctions} from "../../../composables/useReportFunctions";

const props = defineProps<{
  category: Category
}>()

const isEmpty = computed(() => {
  return props.category.children.length == 0;
})

const emptyClass = computed(() => {
  return isEmpty.value ? 'text-black/30 dark:text-stone-50/20' : 'text-black dark:text-stone-50';
})

const agUtilites = useAgGridUtilites()

const categoryName = (category: Category) => {
  if (category.virtual && category.parent_category_id != null)
    return '('+category.name+')';
  return category.name;
}
</script>

<template>
  <tr :class="emptyClass">
    <td class="font-semibold pt-4">
      <Icon
        :icon="category.icon"
        class="inline mr-0.5"
      />
      {{ category.name }}
    </td>
    <td
      v-if="isEmpty"
      class="text-sm font-semibold text-right pt-4"
    >
      {{ agUtilites.currencyFormatterBare(category.transactions_sum_amount) }}
    </td>
    <td
      v-if="isEmpty"
      class="text-sm font-semibold text-right pt-4"
    >
      {{ agUtilites.currencyFormatterBare(category.transactions_sum_amount) }}
    </td>
    <td
      v-if="isEmpty"
      class="text-sm font-semibold text-right pt-4"
    >
      {{ agUtilites.currencyFormatterBare(category.transactions_sum_amount) }}
    </td>
  </tr>
  <tr
    v-for="c in category.children"
    :key="c.name"
  >
    <td class="text-sm">
      <Icon
        :icon="c.icon"
        class="inline mr-0.5"
      />
      {{ categoryName(c) }}
    </td>
    <td class="text-sm text-right">
      {{ agUtilites.currencyFormatterBare(c.transactions_sum_amount) }}
    </td>
    <td class="text-sm text-right">
      {{ agUtilites.currencyFormatterBare(useReportFunctions().budgetSum(c)) }}
    </td>
    <td class="text-sm text-right">
      {{ agUtilites.currencyFormatterBare(useReportFunctions().offsetForChildCategory(c)) }}
    </td>
  </tr>
  <tr
    v-if="!isEmpty"
    class="text-blue-700 dark:text-blue-300/50"
  >
    <td class="pl-5 text-sm">
      Total for <b>{{ category.name }}</b>
    </td>
    <td class="text-sm font-semibold text-right">
      {{ agUtilites.currencyFormatterBare(category.transactions_sum_amount) }}
    </td>
    <td class="text-sm font-semibold text-right">
      {{ agUtilites.currencyFormatterBare(category.children.reduce((acc, currCat) => acc+useReportFunctions().budgetSum(currCat), 0)) }}
    </td>
    <td class="text-sm font-semibold text-right">
      {{ agUtilites.currencyFormatterBare(category.children.reduce((acc, currCat) => acc+useReportFunctions().offsetForChildCategory(currCat), 0)) }}
    </td>
  </tr>
</template>

<style scoped>

</style>
