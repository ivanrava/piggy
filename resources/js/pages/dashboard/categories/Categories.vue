<script setup lang="ts">
import CategoryForm from "../../../components/form/crud/CategoryFormWrapper.vue";
import {onMounted} from "vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";

onMounted(() => {
  useCategoriesStore().selectCategory(null)
})
</script>

<template>
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
  <category-form />
</template>

<style scoped>

</style>
