<script setup lang="ts">
import {Line,Bar} from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement
} from 'chart.js'
import {computed} from "vue";
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, PointElement, LineElement, BarElement)

const props = defineProps<{
  data: Array<{
    time: number
    type: String
  }>
  dateFormat: Intl.DateTimeFormatOptions
  isLine: Boolean
}>()

const toChartDataset = (categoryType) => {
  return props.data
    .filter(dataPoint => dataPoint.type == categoryType)
    .map(value => {
      return {
        x:dateFormatter(value.time),
        y:value.sum
      }
    })
}

const dateFormatter = (time) => {
  return (new Date(time)).toLocaleDateString(undefined, props.dateFormat)
}

const labels = computed(() => {
  return props.data
    .filter((dataPoint, i, array) => dataPoint.time != (array[i-1] ? array[i-1].time : 0))
    .map(dataPoint => dateFormatter(dataPoint.time))
})

const tension = 0.1;
const data = computed(() => {
  return {
    labels: labels.value,
    datasets: [{
      label: 'Total incomes',
      data: toChartDataset('in'),
      borderColor: 'rgb(75,192,157)',
      backgroundColor: '#9ce7c4',
      tension: tension
    },{
      label: 'Total expenses',
      data: toChartDataset('out'),
      borderColor: '#ff6384',
      backgroundColor: '#fcb6c5',
      tension: tension
    }]
  }
});
</script>

<template>
  <Line
    v-if="isLine"
    :options="{responsive:true}"
    :data="data"
  />
  <Bar
    v-else
    :options="{responsive:true}"
    :data="data"
  />
</template>

<style scoped>

</style>
