<template>
  <h1>Categories</h1>
  <div class="flex flex-col h-full w-full justify-between">
    <Transition name="fade-loading" mode="out-in">
      <section v-if="isLoading">

      </section>
      <section v-else-if="categories.length === 0">
        <no-data />
      </section>
      <section class="flex flex-row w-full justify-between" v-else>
        <category-list :categories="categories" />
      </section>
    </Transition>
    <category-form />
  </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import CategoryList from "../../components/CategoryList.vue";
import CategoryForm from "../../components/form/crud/CategoryFormWrapper.vue";
import NoData from "../../components/NoData.vue";

const categories = ref([]);
const isLoading = ref(true);

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
