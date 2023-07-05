<script setup lang="ts">
import TopListChart from "./TopListChart.vue";
import InOutHistoryChart from "./InOutHistoryChart.vue";
import PieChartWrapper from "./PieChartWrapper.vue";

defineProps<{
  form: {
    kind: string
  }
}>()
</script>

<template>
  <top-list-chart
    v-if="form.kind === 'list'"
    :form="form"
  />
  <in-out-history-chart
    v-else-if="form.kind === 'bar' || form.kind === 'line'"
    :form="form"
  />
  <pie-chart-wrapper
    v-else-if="form.kind === 'pie'"
    :form="form"
  />
</template>

<style scoped>

</style>
