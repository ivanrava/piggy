<script setup lang="ts">
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import CardRowSkeleton from "./CardRowSkeleton.vue";
import StatCard from "./StatCard.vue";

const top = ref([]);
const isLoading = ref(false);
onMounted(() => {
  isLoading.value = true;
  axios.get(`/stats/beneficiaries/top`)
    .then(({data}) => {
      top.value = data
    })
    .finally(() => {
      isLoading.value = false;
    })
})
</script>

<template>
  <stat-card title="Top beneficiaries">
    <Transition
      mode="out-in"
      name="fade"
    >
      <ul
        v-if="!isLoading"
        class="flex flex-col justify-around flex-grow"
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
          <span class="font-light pr-2 pl-6">{{ b.sum }}</span>
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
