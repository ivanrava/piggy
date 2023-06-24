<script setup lang="ts">
import {Category} from "../../../composables/interfaces";
import {Icon} from "@iconify/vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {computed} from "vue";

const props = defineProps<{
  category: Category
}>()

const isEmpty = computed(() => {
  return props.category.children.length == 0;
})

const emptyClass = computed(() => {
  return isEmpty.value ? 'text-black/30' : 'text-black';
})

const agUtilites = useAgGridUtilites()
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
      {{ c.name }}
    </td>
    <td class="text-sm text-right">
      {{ agUtilites.currencyFormatterBare(c.transactions_sum_amount) }}
    </td>
  </tr>
  <tr
    v-if="!isEmpty"
    class="text-blue-700"
  >
    <td class="pl-5 text-sm">
      Total for <b>{{ category.name }}</b>
    </td>
    <td class="text-sm font-semibold text-right">
      {{ agUtilites.currencyFormatterBare(category.transactions_sum_amount) }}
    </td>
  </tr>
</template>

<style scoped>

</style>
