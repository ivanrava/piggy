<script setup lang="ts">
import StatCard from "./StatCard.vue";
import AccountCard from "../../../components/AccountCard.vue";
import CardRowSkeleton from "./CardRowSkeleton.vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {computed, ref, watchEffect} from "vue";
import axios from "axios";
const props = defineProps<{
  stat: string,
  interval: string
}>();

const top = ref([]);
const isLoading = ref(false);
watchEffect(() => {
  isLoading.value = true;
  axios.get(`/stats/accounts/top`, {
    params:{
      stat: props.stat,
      interval: props.interval
    }})
    .then(({data}) => {
      top.value = data
    })
    .finally(() => {
      isLoading.value = false;
    })
})
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
  <stat-card :title="descriptions[stat] + timeDescription">
    <Transition
      mode="out-in"
      name="fade"
    >
      <ul
        v-if="!isLoading"
        class="flex flex-col flex-grow h-full"
        :class="top.length > 4 ? 'justify-around' : 'justify-start gap-2'"
      >
        <li
          v-for="a in top"
          :key="a.name"
          class="flex items-center justify-between"
        >
          <account-card
            :account="{
              id: a.id,
              name: a.name,
              icon: a.icon,
              color: '#'+a.color,
              type: a.type,
            }"
            :small="true"
            class="!p-1"
          />
          <span class="font-light pr-2 pl-6 whitespace-nowrap">{{ stat != 'count' ? useAgGridUtilites().currencyFormatterBare(Number(a[stat])) : a[stat] }}</span>
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
