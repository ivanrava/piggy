<script setup lang="ts">
import ChartLineBar from "../../../components/stats/ChartLineBar.vue";
import StatCard from "./StatCard.vue";
import {ref, watchEffect} from "vue";
import axios from "axios";

const props = defineProps<{
  form: {
    kind: string
    interval: string
    stat: string
    filter: string
    filter_id: number
  },
}>()

const transactions = ref([]);
const title = ref('In/Out History');
watchEffect(() => {
  if (props.form.filter != 'all' && props.form.filter_id == null)
    return

  const suffix = props.form.filter === 'all' ? '' : `/${props.form.filter}/${props.form.filter_id}`
  axios.get(`/stats/${props.form.interval}${suffix}`,{
    params: {
      stat: props.form.stat
    }
  })
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

  if (props.form.filter != 'all') {
    title.value = 'Loading...'
    axios.get(`/${props.form.filter}/${props.form.filter_id}`)
      .then(({data}) => {
        title.value = data.data.name
      })
  } else {
    title.value = 'In/Out History'
  }
})

const dateFormats = {
  month: {month:'short', year:'numeric'},
  year: {year:'numeric'}
}
</script>

<template>
  <stat-card :title="title">
    <chart-line-bar
      :data="transactions.map(value => {
        return {
          ...value,
          sum: value[form.stat]
        }
      })"
      :date-format="dateFormats[form.interval]"
      :is-line="form.kind === 'line'"
    />
  </stat-card>
</template>

<style scoped>

</style>
