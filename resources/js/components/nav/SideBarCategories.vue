<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import SideBarCategoriesList from "./SideBarCategoriesList.vue";
import {useCategoriesStore} from "../../composables/useCategoriesStore";

const store = useCategoriesStore();

const isLoading = ref(true);
onMounted(() => {
  isLoading.value = true;
  store.refreshCategories();
  isLoading.value = false;
});

const outCategories = computed(() => {
  return store.categories.filter(value => value.type === 'out')
});

const inCategories = computed(() => {
  return store.categories.filter(value => value.type === 'in')
});
</script>

<template>
  <section class="flex flex-col w-full justify-between pr-2">
    <h2 class="text-red-900 tracking-wide">
      Expense
    </h2>
    <side-bar-categories-list :categories="outCategories" />
    <h2 class="text-green-900 tracking-wide">
      Income
    </h2>
    <side-bar-categories-list :categories="inCategories" />
  </section>
</template>

<style scoped>

</style>
