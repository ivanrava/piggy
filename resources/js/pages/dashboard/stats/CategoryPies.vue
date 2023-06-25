<script setup lang="ts">
import {Account, Beneficiary, Category} from "../../../composables/interfaces";
import {Pie} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, Colors, ArcElement } from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, Colors, ArcElement)

defineProps<{
  accounts: Array<Account>,
  beneficiaries: Array<Beneficiary>,
  category: Category
}>()

const options = (title) => {
  return {
    responsive: true,
    plugins: {
      colors:{enabled: true},
      legend:{display:false},
      title:{text:title,display:true,font:{size:22,weight:'',family:'Inter'}}
    }
  };
}
</script>

<template>
  <section class="w-full flex">
    <div class="w-1/2 px-16 print:p-0">
      <Pie
        :options="options('Accounts distribution')"
        :data="{
          labels: accounts.map(acc => acc.name),
          datasets: [{
            label: `Total of transactions under ${category.name}`,
            data: accounts.map(acc => acc.sum),
            backgroundColor: accounts.map(acc => `#${acc.color}`),
            borderWidth: accounts.length > 1 ? 1 : 0
          }]
        }"
      />
    </div>
    <div class="w-1/2 px-16 print:p-0">
      <Pie
        :options="options('Beneficiaries distribution')"
        :data="{
          labels: beneficiaries.map(ben => ben.name),
          datasets: [{
            label: `Total of transactions under ${category.name}`,
            data: beneficiaries.map(ben => ben.sum),
            borderWidth: beneficiaries.length > 1 ? 1 : 0
          }]
        }"
      />
    </div>
  </section>
</template>

<style scoped>

</style>
