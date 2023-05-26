<script setup lang="ts">
import BeneficiaryImage from "./BeneficiaryImage.vue";
import {Beneficiary} from "../composables/interfaces";

defineProps<{
  beneficiary: Beneficiary
}>()
</script>

<template>
  <router-link
    class="w-56 shadow-sm rounded-lg flex flex-row items-center bg-slate-100 pr-2 unstyled cursor-pointer hover:shadow-md transition-all"
    :to="`/beneficiaries/${beneficiary.id}`"
  >
    <beneficiary-image :beneficiary="beneficiary" />
    <div class="flex flex-col min-w-0">
      <span class="block text-left text-xs font-medium truncate overflow-hidden">
        {{ beneficiary.name }}
      </span>
      <span class="block opacity-60 text-[9px] text-left truncate">
        First added {{ beneficiary.created_at }}
      </span>
    </div>
  </router-link>
</template>

<style scoped>

</style>
