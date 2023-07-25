<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";
import GenericChartWrapper from "./GenericChartWrapper.vue";
import SideBar from "../../../components/nav/SideBar.vue";

const charts = ref([]);
const isLoading = ref(true);
onMounted(() => {
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
      <Transition
        name="fade-loading"
        mode="out-in"
      >
        <div v-if="isLoading">
          <div class="animate-pulse h-12 bg-gray-400 rounded-lg md:w-52 my-4" />
          <div class="flex flex-wrap justify-start">
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-600 bg-gray-400/70 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-500 bg-gray-400/80 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-700 bg-gray-400/70 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-600 bg-gray-400/80 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-700 bg-gray-400/90 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-500 bg-gray-400/50 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-600 bg-gray-400/90 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-600 bg-gray-400/60 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-600 bg-gray-400/90 rounded-lg h-full" />
            </div>
            <div class="animate-pulse h-72 md:w-1/2 xl:w-1/3 2xl:w-1/4 p-2">
              <div class="dark:bg-gray-700 bg-gray-400/60 rounded-lg h-full" />
            </div>
          </div>
        </div>
        <div v-else-if="charts.length == 0">
          <h1>
            No charts defined
          </h1>
          <div
            class="flex flex-col items-center gap-8 justify-center w-full p-8 my-16"
          >
            <img
              class="w-1/3"
              src="/setup_analytics.svg"
              alt="No data"
            >
            <span class="block text-stone-600">
              We will show on this page the charts you have previously defined. Now start building something great!
            </span>
          </div>
        </div>
        <div v-else>
          <h1>Your charts</h1>
          <div class="flex flex-wrap justify-start">
            <generic-chart-wrapper
              v-for="chartForm in charts"
              :key="chartForm.id"
              :form="chartForm"
            />
          </div>
        </div>
      </Transition>
    </section>
    <div class="md:hidden mt-4">
      <side-bar class="rounded-xl" />
    </div>
  </div>
</template>

<style scoped>

</style>
