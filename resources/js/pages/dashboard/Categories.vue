<template>
  <div class="flex flex-row h-full justify-between">
    <section>
      <h1>Categories</h1>
      <category-list :categories="categories" />
      <vue-tree
        style="width: 700px; height: 400px; border: 1px solid gray;"
        :dataset="categories"
        :config="{ nodeWidth: 160, nodeHeight: 20, levelHeight: 100 }"
      >
        <template v-slot:node="{ node, collapsed }">
          <span
            class="font-bold text-xs p-2 text-slate-50 rounded-sm shadow-sm"
            :style="{ border: collapsed ? '2px solid grey' : '' }"
            :class="node.type === 'out' ? 'bg-red-400' : 'bg-green-400'"
          >
            <Icon :icon="node.icon" class="inline" />
            {{ node.name }}
          </span>
        </template>
      </vue-tree>
    </section>
    <section>
      <category-form />
    </section>
  </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import CategoryList from "../../components/CategoryList.vue";
import CategoryForm from "../../components/form/CategoryForm.vue";
import VueTree from '@ssthouse/vue3-tree-chart';
import "@ssthouse/vue3-tree-chart/dist/vue3-tree-chart.css";
import {Icon} from "@iconify/vue";

const categories = ref([]);
const isLoading = ref(false);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/categories');
    categories.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
});
</script>

<style scoped>

</style>
