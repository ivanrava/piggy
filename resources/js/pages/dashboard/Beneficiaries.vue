<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import BeneficiaryForm from "../../components/form/BeneficiaryForm.vue";

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
  <div class="flex flex-row justify-between">
    <section class="flex flex-wrap gap-4">
      <img
        v-for="beneficiary in beneficiaries"
        :src="beneficiary.img"
        :alt="beneficiary.name"
        class="w-1/12 rounded-xl"
      />
    </section>
    <section>
      <beneficiary-form />
    </section>
  </div>
</template>

<style scoped>

</style>
