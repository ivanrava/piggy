<script setup lang="ts">
import {Pie} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, Colors, ArcElement } from 'chart.js'
import {computed} from "vue";
import {useAgGridUtilites} from "../../composables/useAgGridUtilities";
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, Colors, ArcElement)

const props = defineProps<{
  title: String,
  tooltip: String,
  data: Array<{
    name: String,
    sum: Number,
    color?: String,
    type?: String,
  }>
}>();

const options = computed(() => {
  return {
    responsive: true,
    plugins: {
      colors:{enabled: true},
      legend:{display:false},
      title:{text:props.title,display:props.title.length > 0,font:{size:22,weight:'',family:'Inter'}},
      tooltip: {
        callbacks: {
          label: function(context) {
            const num = !props.tooltip.includes('Number') ? useAgGridUtilites().currencyFormatterBare(Number(context.parsed)) : context.parsed
            return context.dataset.label + ": " + num;
          }
        }
      }
    }
  };
})

const palette = ["rgb(65,187,197)", "rgb(28,88,114)", "rgb(135,169,253)", "rgb(103,45,126)", "rgb(239,102,240)", "rgb(240,158,222)", "rgb(176,0,145)", "rgb(154,231,144)", "rgb(28,95,30)", "rgb(59,165,69)", "rgb(42,243,133)", "rgb(104,60,0)", "rgb(200,147,105)", "rgb(253,44,59)", "rgb(228,109,94)", "rgb(153,42,19)", "rgb(218,201,37)", "rgb(137,151,91)", "rgb(179,230,28)", "rgb(254,143,6)"];
const greens = ["rgb(100,200,104)", "rgb(73,167,72)", "rgb(39,186,96)"];
const reds = ["rgb(220,105,104)", "rgb(245,107,105)"]

const trueData = computed(() => {
  return {
    labels: props.data.map(dataPoint => dataPoint.name),
    datasets: [{
      label: props.tooltip,
      data: props.data.map(dataPoint => dataPoint.sum),
      backgroundColor: props.data.map((dataPoint, i) => {
        if ('color' in dataPoint)
          return '#'+dataPoint.color;

        if ('type' in dataPoint)
          return dataPoint.type === 'out' ? reds[i % reds.length] : greens[i % greens.length];

        return palette[i % palette.length];
      }),
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
