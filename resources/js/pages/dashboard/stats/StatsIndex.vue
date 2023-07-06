<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";
import GenericChartWrapper from "./GenericChartWrapper.vue";
import SideBar from "../../../components/nav/SideBar.vue";

const charts = ref([]);
const isLoading = ref(false);
onMounted(() => {
  isLoading.value = true;
  axios.get('/charts')
    .then(({data}) => {
      charts.value = data.data;
    }).finally(() => {
    isLoading.value = false;
  })
})
</script>

<template>
  <div class="h-full flex flex-col justify-between">
    <section class="flex-col overflow-scroll">
      <h1>Your charts</h1>
      <div class="flex flex-wrap justify-start gap-2">
        <generic-chart-wrapper
          v-for="chartForm in charts"
          :key="chartForm.id"
          class="!m-0"
          :form="chartForm"
        />
      </div>
    </section>
    <div class="md:hidden mt-4">
      <side-bar class="rounded-xl" />
    </div>
  </div>
</template>

<style scoped>

</style>
