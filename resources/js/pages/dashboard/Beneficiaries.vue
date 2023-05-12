<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import BeneficiaryForm from "../../components/form/BeneficiaryForm.vue";
import BeneficiaryCard from "../../components/BeneficiaryCard.vue";

const beneficiaries = ref([]);
const isLoading = ref(false);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/beneficiaries');
    beneficiaries.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
});
</script>

<template>
  <h1>Beneficiaries</h1>
  <div class="flex flex-col justify-between">
    <section class="flex flex-wrap gap-4 justify-start">
      <beneficiary-card
        v-for="beneficiary in beneficiaries"
        :beneficiary="beneficiary"
      />
    </section>
    <beneficiary-form />
  </div>
</template>

<style scoped>

</style>
