<template>
  <ul
    v-for="category in categories"
    :key="category.name"
  >
    <li
      class="px-6 py-0.5 rounded-md transition-all cursor-pointer"
      :class="classes(category)"
      @click.stop="selectCategory(category)"
    >
      <Icon
        :icon="category.icon"
        class="inline"
      />
      {{ category.name }}
      <category-list
        :categories="category.children"
      />
    </li>
  </ul>
</template>

<script setup lang="ts">
import {Category} from '../composables/interfaces';
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import {useCategoriesStore} from "../composables/useCategoriesStore";

defineProps<{
  categories: Array<Category>
}>();

const selected = ref(0)

const classes = function(c: Category) {
  if (selected.value === c.id) {
    return c.type === 'out' ? 'bg-red-500 text-stone-50' : 'bg-green-500 text-stone-50'
  } else {
    return c.type === 'out' ? 'hover:bg-red-100/50 hover:!text-red-950' : 'hover:bg-green-100/50 hover:!text-green-950'
  }
}

const selectCategory = (clickedCategory: Category) => {
  useCategoriesStore().selectCategory(clickedCategory);
}
</script>

<style scoped>

</style>
