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
  BarElement, Chart
} from 'chart.js'
import {computed} from "vue";
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, PointElement, LineElement, BarElement)

const props = defineProps<{
  data: Array<{
    time: number
    type: String
  }>
  dateFormat: Intl.DateTimeFormatOptions
  isLine: Boolean,
  inTooltip: string
  outTooltip: string
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
const datasets = computed(() => {
  const datasetIn = {
    label: props.inTooltip,
    data: toChartDataset('in'),
    borderColor: 'rgb(75,192,157)',
    backgroundColor: '#9ce7c4',
    tension: tension
  };
  const datasetOut = {
    label: props.outTooltip,
    data: toChartDataset('out'),
    borderColor: '#ff6384',
    backgroundColor: '#fcb6c5',
    tension: tension
  };
  const datasets = [];
  if (datasetIn.data.length > 0)
    datasets.push(datasetIn)
  if (datasetOut.data.length > 0)
    datasets.push(datasetOut)
  return datasets;
})

const tension = 0.1;
const data = computed(() => {
  return {
    labels: labels.value,
    datasets: datasets.value
  }
});
const options = {
  responsive: true,
  scales: {
    y: {
      ticks: {
        min: 0,
        beginAtZero: true,
        callback: function(value, index, values) {
          if (Math.floor(value) === value) {
            return value;
          }
        }
      }
    }
  }
}

const updateChartTextColor = () => {
  if(window.matchMedia('(prefers-color-scheme: dark)').matches){
    Chart.defaults.color = '#ccc';
  } else {
    Chart.defaults.color = '#555';
  }
}
updateChartTextColor();
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateChartTextColor)
</script>

<template>
  <div class="relative w-full h-full">
    <div
      v-if="datasets.length == 0"
      class="absolute w-full h-full"
    >
      <div class="flex h-full justify-center items-center">
        <span class="opacity-60 text-xl tracking-wide">
          No data found
        </span>
      </div>
    </div>
    <Line
      v-if="isLine"
      class="absolute top-1/2 -translate-y-1/2"
      :options="options"
      :data="data"
    />
    <Bar
      v-else
      class="absolute top-1/2 -translate-y-1/2"
      :options="options"
      :data="data"
    />
  </div>
</template>

<style scoped>

</style>
