<script setup lang="ts">
import {onMounted, ref} from "vue";
import BudgetRow from "./BudgetRow.vue";
import NoData from "../../../components/NoData.vue";
import BudgetForm from "./BudgetForm.vue";
import {useBudgetStore} from "../../../composables/useBudgetStore";

const store = useBudgetStore();

onMounted(() => {
  store.setYear(new Date().getFullYear())
})

const showForm = ref<boolean>(false);
</script>

<template>
  <div class="h-full flex flex-col justify-between">
    <section class="overflow-scroll">
      <h1>Budget</h1>
      <Transition
        mode="out-in"
        name="fade-loading"
      >
        <section
          v-if="store.isLoading"
          class="flex flex-col gap-4"
        >
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-32 dark:bg-gray-500 bg-gray-400/70 rounded-lg" />
          <div class="w-full animate-pulse h-28 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400/70 rounded-lg" />
          <div class="w-full animate-pulse h-28 dark:bg-gray-700 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-32 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-28 dark:bg-gray-700 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400/70 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-500 bg-gray-400 rounded-lg" />
        </section>
        <section v-else-if="store.categories.length == 0">
          <no-data class="my-8" />
        </section>
        <section
          v-else
          class="flex flex-col pb-4"
        >
          <BudgetRow
            v-for="category in store.categories"
            :key="category.id"
            :category="category"
            @edit="store.editBudget(category); showForm = true"
          />
        </section>
      </Transition>
      <BudgetForm
        :show-form="showForm"
        @update="store.refreshBudgets"
        @close="showForm = false"
      />
    </section>
  </div>
</template>

<style scoped>

</style>
