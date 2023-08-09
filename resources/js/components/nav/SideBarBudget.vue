<script setup lang="ts">
import axios from "axios";
import {ref} from "vue";
import {useBudgetStore} from "../../composables/useBudgetStore";

const store = useBudgetStore();

const years = ref();
axios.get('/budget/years').then((data) => {
  if (data.data.includes('2023')) {
    years.value = data.data;
  } else {
    years.value = [...data.data, 2023];
  }
})
</script>

<template>
  <section>
    <h2 class="my-4">
      Years
    </h2>
    <ul class="px-1 flex flex-row flex-wrap gap-y-4">
      <li
        v-for="year in years"
        :key="year"
        class="text-center mr-4 w-16 text-lg"
      >
        <a
          class="underline cursor-pointer hover:opacity-60 transition-all"
          :class="{'text-pink-100': year == store.year}"
          @click="store.setYear(year)"
        >
          {{ year }}
        </a>
      </li>
    </ul>
  </section>
</template>

<style scoped>

</style>
