<script setup lang="ts">
import {ref, watchEffect} from "vue";
import axios from "axios";
import {Icon} from "@iconify/vue";
import CardRowSkeleton from "./CardRowSkeleton.vue";
import StatCard from "./StatCard.vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";

const props = defineProps<{
  stat: string,
  interval: string
}>();

const top = ref([]);
const isLoading = ref(false);
watchEffect(() => {
  isLoading.value = true;
  axios.get(`/stats/categories/top`, {
    params:{
      stat: props.stat,
      interval: props.interval
    }
  })
    .then(({data}) => {
      top.value = data
    })
    .finally(() => {
      isLoading.value = false;
    })
})

const textColor = (type) => {
  return type === 'out' ? 'text-red-700' : 'text-green-700';
}
const descriptions = {
  max: 'Highest transaction',
  avg: 'Average transaction',
  count: 'Number of transactions',
  sum: 'Total transactions'
}
</script>

<template>
  <stat-card :title="descriptions[stat]">
    <Transition
      mode="out-in"
      name="fade"
    >
      <ul
        v-if="!isLoading"
        class="flex flex-col justify-around flex-grow h-full"
      >
        <li
          v-for="c in top"
          :key="c.name"
          :class="textColor(c.type)"
          class="flex items-center justify-between gap-2"
        >
          <Icon
            :icon="c.icon"
            class="w-12"
          />
          <span class="font-semibold w-full overflow-hidden text-ellipsis whitespace-nowrap">{{ c.name }}</span>
          <span class="font-light pr-2 pl-6 whitespace-nowrap">{{ stat != 'count' ? useAgGridUtilites().currencyFormatterBare(Number(c[stat])) : c[stat] }}</span>
        </li>
      </ul>
      <ul
        v-else
        class="flex flex-col justify-around flex-grow h-full"
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
