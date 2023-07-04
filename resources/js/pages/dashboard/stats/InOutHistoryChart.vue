<script setup lang="ts">
import ChartLineBar from "../../../components/stats/ChartLineBar.vue";
import StatCard from "./StatCard.vue";
import {ref, watchEffect} from "vue";
import axios from "axios";

const props = defineProps<{
  form: {
    interval: String
    isLine: Boolean
    filter: String,
    filterObj: {
      id: Number,
      name: String
    }
  }
}>()

const transactions = ref([]);
watchEffect(() => {
  const suffix = props.form.filter === 'all' ? '' : `/${props.form.filter}/${props.form.filterObj.id}`
  axios.get(`/stats/${props.form.interval}${suffix}`)
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
  <stat-card :title="form.filter === 'all' ? 'In/Out History' : form.filterObj.name">
    <chart-line-bar
      :data="transactions"
      :date-format="dateFormats[form.interval]"
      :is-line="form.isLine"
    />
  </stat-card>
</template>

<style scoped>

</style>
