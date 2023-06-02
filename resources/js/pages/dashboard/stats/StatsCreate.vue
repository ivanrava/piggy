<script setup lang="ts">
import {Bar} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import {onMounted, ref} from "vue";
import axios from "axios";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const transactions = ref([]);
onMounted(() => {
  axios.get('/transactions')
    .then(({data}) => {
      transactions.value = data
    })
})
const months = ['January','February','March','April','May','June','July','September','October','November','December'];
</script>

<template>
  <Bar
    :options="{responsive: true}"
    :data="{labels: months, datasets: [{
      label: 'Transactions',
      data: [40,20,12],
      borderWidth: 1
    }]}"
  />
</template>

<style scoped>

</style>
