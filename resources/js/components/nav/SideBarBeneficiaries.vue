<script setup lang="ts">
import BeneficiaryCard from "../BeneficiaryCard.vue";
import {useBeneficiariesStore} from "../../composables/useBeneficiariesStore";
import {useRoute} from "vue-router";
import {Beneficiary} from "../../composables/interfaces";
import {onMounted} from "vue";
import axios from "axios";

const store = useBeneficiariesStore();

const opacityClass = (beneficiary: Beneficiary) => {
  if (useRoute().path.endsWith('beneficiaries')) {
    return 'opacity-60'
  } else {
    return beneficiary.id == Number(useRoute().params.id) ? 'opacity-100' : 'opacity-40'
  }
}

onMounted(async () => {
  if (store.beneficiaries.length > 0)
    return

  try {
    const res = axios.get('/beneficiaries');
    store.setBeneficiaries((await res).data.data);
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
})
</script>

<template>
  <section>
    <beneficiary-card
      v-for="beneficiary in store.getBeneficiaries()"
      :key="beneficiary.id"
      :beneficiary="beneficiary"
      :hide-bg="true"
      :small="true"
      class="hover:opacity-100"
      :class="opacityClass(beneficiary)"
    />
  </section>
</template>

<style scoped>

</style>
