<script setup lang="ts">
import StatCard from "./StatCard.vue";
import ChartPie from "../../../components/stats/ChartPie.vue";
import {computed, ref, watchEffect} from "vue";
import axios from "axios";

const props = defineProps<{
  form: {
    interval: string
    filter: string
    stat: string,
    filter_id: number,
    filter_group: string
  }
}>()

const isLoading = ref(false);
const top = ref([]);
const title = ref('');
watchEffect(() => {
  const suffix = props.form.filter_id != null ? `/${props.form.filter_id}/${props.form.filter_group}` : '';

  isLoading.value = true;
  axios.get(`/stats/${props.form.filter}${suffix}`, {
    params:{
      stat: props.form.stat,
      interval: props.form.interval
    }})
    .then(({data}) => {
      top.value = data
    })
    .finally(() => {
      isLoading.value = false;
    })

  if (props.form.filter_id != null) {
    title.value = 'Loading...'
    axios.get(`/${props.form.filter}/${props.form.filter_id}`)
      .then(({data}) => {
        title.value = data.data.name
      })
  } else {
    title.value = props.form.filter.slice(0,1).toUpperCase() + props.form.filter.slice(1,props.form.filter.length);
  }
})

const intervalDescs = {
  year: '(last year)',
  month: '(last month)',
  all: ''
}
const descriptions = {
  max: 'Highest transaction',
  avg: 'Average transaction',
  count: 'Number of transactions',
  sum: 'Total transactions'
}
</script>

<template>
  <stat-card :title="title + ' ' + intervalDescs[form.interval]">
    <chart-pie
      title=""
      :data="top.map(value => {
        return {
          ...value,
          sum: value[form.stat]
        }
      })"
      :tooltip="descriptions[form.stat]"
    />
  </stat-card>
</template>

<style scoped>

</style>
