<script setup lang="ts">
import {ref, watchEffect} from "vue";
import axios from "axios";
import {Icon} from "@iconify/vue";
import CardRowSkeleton from "./CardRowSkeleton.vue";
import StatCard from "./StatCard.vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {computed} from "vue";

const props = defineProps<{
  stat: string,
  interval: string,
  favorite: boolean
  id: number
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
  return type === 'out' ? 'text-red-700 dark:text-red-400' : 'text-green-700 dark:text-green-400';
}
const descriptions = {
  max: 'Highest transaction',
  avg: 'Average transaction',
  count: 'Number of transactions',
  sum: 'Total transactions'
}
const timeDescription = computed(() => {
  if (props.interval !== 'all')
    return ` (last ${props.interval})`

  return ' '
})
</script>

<template>
  <stat-card
    :id="id"
    :favorite="favorite"
    :title="descriptions[stat] + timeDescription"
  >
    <Transition
      mode="out-in"
      name="fade"
    >
      <ul
        v-if="!isLoading && top.length > 0"
        class="flex flex-col flex-grow h-full"
        :class="top.length > 4 ? 'justify-around' : 'justify-start gap-2'"
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
      <ul v-else-if="top.length == 0">
        <li class="opacity-60 tracking-wide text-xl">
          No data found
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
