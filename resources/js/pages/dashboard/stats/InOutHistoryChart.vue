<script setup lang="ts">
import ChartLine from "./ChartLine.vue";
import StatCard from "./StatCard.vue";
import {ref, watchEffect} from "vue";
import axios from "axios";

const props = defineProps<{
  form: {
    interval: String
  }
}>()

const transactions = ref([]);
watchEffect(() => {
  axios.get(`/stats/${props.form.interval}`)
    .then(({data}) => {
      transactions.value = data
      // Take the last time points
      const times = transactions.value
        .filter((dataPoint, i, array) => dataPoint.time != (array[i-1] ? array[i-1].time : 0))
        .slice(-5)
        .map(dataPoint => dataPoint.time)
      transactions.value = transactions.value
        .filter(dataPoint => times.includes(dataPoint.time))
    })
})

const dateFormats = {
  month: {month:'short', year:'numeric'},
  year: {year:'numeric'}
}
</script>

<template>
  <stat-card title="In/Out History">
    <chart-line
      :data="transactions"
      :date-format="dateFormats[form.interval]"
    />
  </stat-card>
</template>

<style scoped>

</style>
