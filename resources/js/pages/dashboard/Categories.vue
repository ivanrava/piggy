<template>
  <category-list :categories="categories" />
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import CategoryList from "../../components/CategoryList.vue";

const categories = ref([]);
const isLoading = ref(false);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/categories');
    categories.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
});
</script>

<style scoped>

</style>
