<script setup lang="ts">

import {onMounted, ref} from "vue";
import axios from "axios";
import {Category} from "../../../composables/interfaces";
import BudgetRow from "./BudgetRow.vue";

const isLoading = ref<boolean>(true);
const categories = ref<Array<Category>>(null);
onMounted(() => {
    axios.get('/budget').then(({data}) => {
    categories.value = data.data;
  }).finally(() => {
    isLoading.value = false;
  })
})
</script>

<template>
  <section class="flex flex-col">
    <h1>Budget</h1>
    <div class="flex flex-col pb-4">
      <BudgetRow
        v-for="category in categories"
        :key="category.id"
        :category="category"
      />
    </div>
  </section>
</template>

<style scoped>

</style>
