<script setup lang="ts">
import {computed} from "vue";
import {Category} from "../../../composables/interfaces";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {useBarColors} from "../../../composables/useBarColors";

const props = defineProps<{
  category: Category
}>();

const total = computed(() => {
  const monthSum: number = Object.values(props.category.expenditures).reduce((accumul, currValue) => accumul + Number(currValue), 0)
  return monthSum;
})

const percentage = computed(() => {
  let percentage: number = total.value / Number(props.category.budget) * 100
  percentage = percentage > 100 ? 100 : percentage;
  return percentage;
})
</script>

<template>
  <aside class="flex flex-row items-center w-2/3">
    <span
      :class="useBarColors().barTextColor(percentage, category.type === 'out')"
      class="w-24 text-right"
    >
      {{ useAgGridUtilites().currencyFormatterBare(total) }}
    </span>
    <div
      class="h-6 my-2 mx-8 flex-grow rounded-lg"
      :class="useBarColors().barBg"
    >
      <div
        class="h-full rounded-lg"
        :class="useBarColors().barBgColor(percentage, category.type === 'out')"
        :style="{width: `${percentage}%`}"
      />
    </div>
    <span class="w-24 font-bold text-left">{{ useAgGridUtilites().currencyFormatterBare(category.budget) }}</span>
  </aside>
</template>

<style scoped>

</style>
