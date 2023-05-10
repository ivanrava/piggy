<template>
  <ul
    v-for="category in categories"
    :key="category.name"
    class="ml-2"
  >
    <li>
      <Icon :icon="category.icon" class="inline" />
      {{ category.name }}
      <category-list :categories="category.children" />
    </li>
  </ul>
</template>

<script setup lang="ts">
import {Category} from '../composables/interfaces';
import {Icon} from "@iconify/vue";

defineProps<{
  categories: Array<Category>
}>();
</script>

<style scoped>

</style>
