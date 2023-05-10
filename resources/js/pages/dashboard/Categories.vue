<template>
  <h1>Categories</h1>
  <div class="flex flex-row h-full justify-between">
    <section>
      <category-list :categories="categories" />
    </section>
    <section>
      <category-form />
    </section>
  </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import CategoryList from "../../components/CategoryList.vue";
import CategoryForm from "../../components/form/CategoryForm.vue";

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
