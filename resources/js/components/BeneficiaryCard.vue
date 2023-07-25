<script setup lang="ts">
import BeneficiaryImage from "./BeneficiaryImage.vue";
import {Beneficiary} from "../composables/interfaces";

export interface Props {
  beneficiary: Beneficiary
  hideBg?: boolean
  small?: boolean
}

withDefaults(defineProps<Props>(), {
  hideBg: false,
  small: false
})
</script>

<template>
  <router-link
    class="w-full md:w-56 rounded-lg flex flex-row items-center pr-2 unstyled cursor-pointer transition-all"
    :class="{'bg-stone-100 dark:bg-stone-950/50 shadow-sm hover:shadow-md':!hideBg}"
    :to="`/beneficiaries/${beneficiary.id}`"
  >
    <beneficiary-image
      :beneficiary="beneficiary"
      :class="{'!h-12 !w-12':small}"
    />
    <div class="flex flex-col min-w-0">
      <span class="block text-left text-sm md:text-xs font-normal md:font-medium truncate overflow-hidden tracking-wide">
        {{ beneficiary.name }}
      </span>
      <span class="block opacity-40 md:opacity-60 text-[10px] md:text-[9px] text-left truncate">
        First added {{ beneficiary.created_at }}
      </span>
    </div>
  </router-link>
</template>

<style scoped>

</style>
