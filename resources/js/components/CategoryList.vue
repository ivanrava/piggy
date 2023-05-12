<template>
  <ul
    v-for="category in categories"
    :key="category.name"
    class="ml-2"
  >
    <li
      class="px-2 py-0.5 my-0.5 rounded-md transition-all cursor-pointer"
      :class="classes(category)"
      @click="loadCategory(category)"
    >
      <Icon :icon="category.icon" class="inline" />
      {{ category.name }}
      <category-list :categories="selectedCategory.children" v-if="selected === category.id"/>
    </li>
  </ul>
</template>

<script setup lang="ts">
import {Category} from '../composables/interfaces';
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import axios from "axios";

defineProps<{
  categories: Array<Category>
}>();

const selected = ref(0)

const classes = function(c: Category) {
  if (selected.value === c.id) {
    return c.type === 'out' ? 'bg-red-500 text-stone-50' : 'bg-green-500 text-stone-50'
  } else {
    return c.type === 'out' ? 'hover:bg-red-100 hover:!text-red-950' : 'hover:bg-green-100 hover:!text-green-950'
  }
}

const selectedCategory = ref({});
const isLoading = ref(false);

const loadCategory = async function(clickedCategory: Category) {
  selectedCategory.value = {};
  selected.value = clickedCategory.id

  isLoading.value = true;
  try {
    const res = axios.get('/categories/'+clickedCategory.id);
    selectedCategory.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
}
</script>

<style scoped>

</style>
