<template>
  <ul
    v-for="category in categories"
    :key="category.name"
  >
    <li
      class="pr-2 py-0.5 rounded-md transition-all cursor-pointer whitespace-nowrap overflow-clip text-ellipsis"
      :class="`${classes(category)} ${category.parent_category_id == null ? 'pl-2' : 'pl-6'}`"
      @click.stop="router.push(`/categories/${category.id}`)"
    >
      <Icon
        :icon="category.icon"
        class="inline"
      />
      {{ categoryName(category) }}
      <side-bar-categories-list
        :categories="category.children"
      />
    </li>
  </ul>
</template>

<script setup lang="ts">
import {Category} from '../../../composables/interfaces';
import {Icon} from "@iconify/vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";
import {useRouter} from "vue-router";

defineProps<{
  categories: Array<Category>
}>();

const store = useCategoriesStore();
const router = useRouter();

const classes = function(c: Category) {
  if (store.selectedCategory != null && store.selectedCategory.id === c.id) {
    return c.type === 'out' ? 'bg-red-500/70 text-stone-50 font-semibold' : 'bg-green-500/70 text-stone-50 font-semibold'
  } else {
    return c.type === 'out' ? 'hover:bg-red-100/50 hover:!text-red-950' : 'hover:bg-green-100/50 hover:!text-green-950'
  }
}

const categoryName = (category: Category) => {
  if (category.virtual && category.parent_category_id != null)
    return '('+category.name+')';
  return category.name;
}
</script>

<style scoped>

</style>
