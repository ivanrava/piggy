<script setup lang="ts">
import StatCard from "./StatCard.vue";
import ChartPie from "../../../components/stats/ChartPie.vue";
import {ref, watchEffect} from "vue";
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
})
</script>

<template>
  <stat-card title="Ciao">
    <chart-pie
      title=""
      :data="top.map(value => {
        return {
          ...value,
          sum: value[props.form.stat]
        }
      })"
      tooltip=""
    />
  </stat-card>
</template>

<style scoped>

</style>
