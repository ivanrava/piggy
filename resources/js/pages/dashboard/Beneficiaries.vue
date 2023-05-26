<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import BeneficiaryForm from "../../components/form/crud/BeneficiaryForm.vue";
import BeneficiaryCard from "../../components/BeneficiaryCard.vue";

const beneficiaries = ref([]);
const isLoading = ref(true);

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
    <Transition name="fade" mode="out-in">
      <section v-if="isLoading" class="flex flex-wrap items-center w-full gap-4">
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-56"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-48"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-48"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-56"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52"></div>
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-48"></div>
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56"></div>
      </section>
      <section class="flex flex-wrap gap-4 justify-start pb-4" v-else>
        <beneficiary-card
          v-for="beneficiary in beneficiaries"
          :beneficiary="beneficiary"
        />
      </section>
    </Transition>
    <beneficiary-form />
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
