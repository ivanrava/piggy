<script setup lang="ts">
import {Category} from "../composables/interfaces";
import {Icon} from "@iconify/vue";
import {useAgGridUtilites} from "../composables/useAgGridUtilities";

defineProps<{
  category: Category
}>()

const agUtilites = useAgGridUtilites()
</script>

<template>
  <tr>
    <td class="font-semibold pt-4">
      <Icon
        :icon="category.icon"
        class="inline mr-0.5"
      />
      {{ category.name }}
    </td>
  </tr>
  <tr
    v-for="c in category.children"
    :key="c.name"
  >
    <td>
      <Icon
        :icon="c.icon"
        class="inline mr-0.5 text-sm"
      />
      {{ c.name }}
    </td>
    <td class="text-sm text-right">
      {{ agUtilites.currencyFormatterBare(c.transactions_sum_amount) }}
    </td>
  </tr>
  <tr class="text-red-900">
    <td class="pl-5">
      Total for <b>{{ category.name }}</b>
    </td>
    <td class="text-sm font-semibold text-right">
      {{ agUtilites.currencyFormatterBare(category.transactions_sum_amount) }}
    </td>
  </tr>
</template>

<style scoped>

</style>
