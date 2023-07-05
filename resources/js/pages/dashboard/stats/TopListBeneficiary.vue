<script setup lang="ts">
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";
import {computed, ref, watchEffect} from "vue";
import axios from "axios";
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
  axios.get(`/stats/beneficiaries/top`, {
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
          v-for="b in top"
          :key="b.name"
          class="flex items-center justify-between"
        >
          <beneficiary-image
            :beneficiary="b"
            class="!w-8 !h-8 !p-1"
          />
          <span class="font-semibold text-slate-700 text-xs w-full overflow-hidden text-ellipsis whitespace-nowrap">{{ b.name }}</span>
          <span class="font-light pr-2 pl-6 whitespace-nowrap">{{ stat != 'count' ? useAgGridUtilites().currencyFormatterBare(Number(b[stat])) : b[stat] }}</span>
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
