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
          <div class="flex flex-wrap justify-start gap-2">
            <div class="animate-pulse h-72 bg-gray-400/70 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/70 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/70 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/80 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/70 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/80 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/90 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/70 rounded-lg md:w-[23.5rem]" />
            <div class="animate-pulse h-72 bg-gray-400/80 rounded-lg md:w-[23.5rem]" />
          </div>
        </div>
        <div v-else-if="charts.length == 0">
          <h1>
            No category selected
          </h1>
          <div
            class="flex flex-col items-center gap-8 justify-center w-full p-8 my-16"
          >
            <img
              class="w-1/3"
              src="/investing.svg"
              alt="No data"
            >
            <span class="block text-stone-600">
              We will load data from your categories in here, please click one of the categories on the sidebar.
            </span>
          </div>
        </div>
        <div v-else>
          <h1>Your charts</h1>
          <div class="flex flex-wrap justify-start gap-2">
            <generic-chart-wrapper
              v-for="chartForm in charts"
              :key="chartForm.id"
              class="!m-0"
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
