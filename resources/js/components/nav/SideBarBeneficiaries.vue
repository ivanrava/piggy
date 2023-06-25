<script setup lang="ts">
import BeneficiaryCard from "../BeneficiaryCard.vue";
import {useBeneficiariesStore} from "../../composables/useBeneficiariesStore";
import {useRoute} from "vue-router";
import {Beneficiary} from "../../composables/interfaces";

const store = useBeneficiariesStore();

const opacityClass = (beneficiary: Beneficiary) => {
  if (useRoute().path.endsWith('beneficiaries')) {
    return 'opacity-60'
  } else {
    return beneficiary.id == Number(useRoute().params.id) ? 'opacity-100' : 'opacity-40'
  }
}
</script>

<template>
  <beneficiary-card
    v-for="beneficiary in store.beneficiaries"
    :key="beneficiary.id"
    :beneficiary="beneficiary"
    :hide-bg="true"
    :small="true"
    class="hover:opacity-100"
    :class="opacityClass(beneficiary)"
  />
</template>

<style scoped>

</style>
