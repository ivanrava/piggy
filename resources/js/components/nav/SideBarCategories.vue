<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import SideBarCategoriesList from "./SideBarCategoriesList.vue";
import {useCategoriesStore} from "../../composables/useCategoriesStore";
import EmptyListMessage from "../EmptyListMessage.vue";

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
    <h2 class="text-red-900 dark:text-red-300 tracking-wide">
      Expense
    </h2>
    <side-bar-categories-list :categories="outCategories" />
    <EmptyListMessage v-if="outCategories.length == 0">
      Still no categories here...
    </EmptyListMessage>
    <h2 class="text-green-900 dark:text-green-300 tracking-wide">
      Income
    </h2>
    <side-bar-categories-list :categories="inCategories" />
    <EmptyListMessage v-if="inCategories.length == 0">
      Still no categories here...
    </EmptyListMessage>
  </section>
</template>

<style scoped>

</style>
