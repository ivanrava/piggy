<script setup lang="ts">
import {computed} from "vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {useBarColors} from "../../../composables/useBarColors";

const props = defineProps<{
  month: string;
  budget: string;
  expenditure: string|number;
  isOut: boolean;
}>();

const percentage = computed(() => {
  let percentage: number = Number(props.expenditure) / Number(props.budget) * 100
  percentage = percentage > 100 ? 100 : percentage;
  return percentage;
})
</script>

<template>
  <div class="flex flex-col items-center gap-2">
    <div class="flex flex-col items-center">
      <span class="text-xs font-extralight">{{ month }}</span>
      <span class="text-xs font-bold">{{ useAgGridUtilites().currencyFormatterBare(Number(budget)) }}</span>
    </div>
    <div
      class="w-6 h-16 rounded-lg flex flex-col justify-end shadow-lg"
      :class="useBarColors().barBg"
    >
      <div
        class="w-full rounded-lg"
        :class="useBarColors().barBgColor(percentage, isOut)"
        :style="{height: `${percentage}%`}"
      />
    </div>
    <span
      class="text-xs"
      :class="useBarColors().barTextColor(percentage, isOut)"
    >
      {{ useAgGridUtilites().currencyFormatterBare(Number(expenditure)) }}
    </span>
  </div>
</template>

<style scoped>

</style>
