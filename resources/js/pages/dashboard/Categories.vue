<template>
  <h1 v-if="store.selectedCategory == null">
    No category selected
  </h1>
  <h1
    v-else
    class="flex gap-2"
  >
    <Icon :icon="store.selectedCategory.icon" />
    <span>
      {{ store.selectedCategory.name }}
    </span>
  </h1>
  <div class="flex flex-col h-full w-full justify-between">
    <Transition
      name="fade-loading"
      mode="out-in"
    >
      <ul v-if="store.selectedCategory != null">
        <li>
          <b>Category type:</b>
          <span v-if="store.selectedCategory.type == 'out'">
            Expense
          </span>
          <span v-else>
            Income
          </span>
        </li>
      </ul>
      <div
        v-else
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
    </Transition>
    <category-form />
  </div>
</template>

<script setup lang="ts">
import CategoryForm from "../../components/form/crud/CategoryFormWrapper.vue";
import {useCategoriesStore} from "../../composables/useCategoriesStore";
import {Icon} from "@iconify/vue";

const store = useCategoriesStore()
</script>

<style scoped>

</style>
