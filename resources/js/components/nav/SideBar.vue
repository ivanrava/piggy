<template>
  <nav class="bg-stone-300/80 h-full overflow-scroll px-4 py-2">
    <section
      v-if="useRoute().path.startsWith('/categories')"
      class="flex flex-col w-full justify-between pr-2"
    >
      <h2 class="text-red-900 tracking-wide">
        Expense
      </h2>
      <side-bar-categories :categories="outCategories" />
      <h2 class="text-green-900 tracking-wide">
        Income
      </h2>
      <side-bar-categories :categories="inCategories" />
    </section>
  </nav>
</template>

<script setup lang="ts">
import SideBarCategories from "./SideBarCategories.vue";
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
const categories = ref([]);
const isLoading = ref(true);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/categories/root');
    categories.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
});

const outCategories = computed(() => {
  return categories.value.filter(value => value.type === 'out')
});

const inCategories = computed(() => {
  return categories.value.filter(value => value.type === 'in')
})
</script>

<style scoped>
</style>
