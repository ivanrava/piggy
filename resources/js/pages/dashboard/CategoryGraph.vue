<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import VueTree from '@ssthouse/vue3-tree-chart';
import "@ssthouse/vue3-tree-chart/dist/vue3-tree-chart.css";

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

<template>
  <vue-tree
    class="w-full h-full"
    id="graph"
    :dataset="categories"
    :config="{ nodeWidth: 160, nodeHeight: 20, levelHeight: 100 }"
  >
    <template v-slot:node="{ node, collapsed }">
          <span
            class="font-bold text-xs p-2 text-slate-50 rounded-sm"
            :style="{ border: collapsed ? '2px solid grey' : '' }"
            :class="node.type === 'out' ? 'bg-red-400' : 'bg-green-400'"
          >
            <Icon :icon="node.icon" class="inline" />
            {{ node.name }}
          </span>
    </template>
  </vue-tree>
</template>

<style scoped lang="scss">
$width: 20px;
$line: 1px;
$color: #ddd;
#graph {
  background:
    repeating-linear-gradient(
      to right,
      transparent,
      transparent $width,
      $color $width,
      $color $width + $line
    ),
    repeating-linear-gradient(
      to bottom,
      transparent,
      transparent $width,
      $color $width,
      $color $width + $line
    ),
    linear-gradient(45deg, white, white);
}
</style>
