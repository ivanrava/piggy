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
