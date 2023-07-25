<script setup lang="ts">
import CategoryForm from "../../../components/form/crud/CategoryFormWrapper.vue";
import {onMounted} from "vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";
import SideBarCategories from "../../../components/nav/SideBarCategories.vue";

onMounted(() => {
  useCategoriesStore().selectCategory(null)
})
</script>

<template>
  <div class="h-full flex flex-col justify-between">
    <section class="overflow-scroll">
      <div class="hidden md:block">
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
          <span class="block text-stone-600 dark:text-stone-200/50">
            We will load data from your categories in here, please click one of the categories on the sidebar.
          </span>
        </div>
      </div>
      <div class="md:hidden">
        <h1>Categories</h1>
        <side-bar-categories />
      </div>
    </section>
    <category-form />
  </div>
</template>

<style scoped>

</style>
