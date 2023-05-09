<template>
  <ul
    v-for="category in categories"
    :key="category.name"
    class="list-disc ml-4"
  >
    <li>
      {{ category.name }} / {{ category.type }}
      <category-list :categories="category.children" />
    </li>
  </ul>
</template>

<script setup lang="ts">
import {Category} from '../composables/interfaces';

defineProps<{
  categories: Array<Category>
}>();
</script>

<style scoped>

</style>
