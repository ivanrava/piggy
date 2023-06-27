<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {Icon} from "@iconify/vue";
import CardRowSkeleton from "./CardRowSkeleton.vue";
import StatCard from "./StatCard.vue";

const top = ref([]);
const isLoading = ref(false);
onMounted(() => {
  isLoading.value = true;
  axios.get(`/stats/categories/top`)
    .then(({data}) => {
      top.value = data
    })
    .finally(() => {
      isLoading.value = false;
    })
})
</script>

<template>
  <stat-card title="Top categories">
    <Transition
      mode="out-in"
      name="fade"
    >
      <ul
        v-if="!isLoading"
        class="flex flex-col justify-around flex-grow"
      >
        <li
          v-for="c in top"
          :key="c.name"
          class="flex items-center justify-between gap-2"
        >
          <Icon
            :icon="c.icon"
            class="w-12"
          />
          <span class="font-semibold text-slate-700 w-full overflow-hidden text-ellipsis whitespace-nowrap">{{ c.name }}</span>
          <span class="font-light pr-2 pl-6">{{ c.sum }}</span>
        </li>
      </ul>
      <ul
        v-else
        class="flex flex-col justify-around flex-grow"
      >
        <card-row-skeleton />
        <card-row-skeleton />
        <card-row-skeleton />
        <card-row-skeleton />
        <card-row-skeleton />
      </ul>
    </Transition>
  </stat-card>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
