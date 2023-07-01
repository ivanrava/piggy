<script setup lang="ts">
import {Pie} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, Colors, ArcElement } from 'chart.js'
import {computed} from "vue";
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, Colors, ArcElement)

const props = defineProps<{
  title: String,
  tooltip: String,
  data: Array<{
    name: String,
    sum: Number,
    color?: String,
  }>
}>();

const options = computed(() => {
  return {
    responsive: true,
    plugins: {
      colors:{enabled: true},
      legend:{display:false},
      title:{text:props.title,display:true,font:{size:22,weight:'',family:'Inter'}}
    }
  };
})

const trueData = computed(() => {
  // FIXME: is there a more compact way to do this 'if-color'?
  const hasColor = 'color' in props.data[0];
  if (hasColor)
    return {
      labels: props.data.map(dataPoint => dataPoint.name),
      datasets: [{
        label: props.tooltip,
        data: props.data.map(dataPoint => dataPoint.sum),
        backgroundColor: props.data.map(acc => `#${acc.color}`),
        borderWidth: props.data.length > 1 ? 1 : 0
      }]
    }
  else
    return {
      labels: props.data.map(dataPoint => dataPoint.name),
      datasets: [{
        label: props.tooltip,
        data: props.data.map(dataPoint => dataPoint.sum),
        borderWidth: props.data.length > 1 ? 1 : 0
      }]
    }
})
</script>

<template>
  <Pie
    :options="options"
    :data="trueData"
  />
</template>

<style scoped>

</style>
