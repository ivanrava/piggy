<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import BeneficiaryForm from "../../components/form/crud/BeneficiaryFormWrapper.vue";
import BeneficiaryCard from "../../components/BeneficiaryCard.vue";
import NoData from "../../components/NoData.vue";
import {useBeneficiariesStore} from "../../composables/useBeneficiariesStore";

const store = useBeneficiariesStore();
const isLoading = ref(true);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/beneficiaries');
    store.setBeneficiaries((await res).data.data);
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
});
</script>

<template>
  <div class="flex flex-col justify-between">
    <h1>Beneficiaries</h1>
    <Transition
      name="fade-loading"
      mode="out-in"
    >
      <section
        v-if="isLoading"
        class="flex flex-wrap items-center w-full gap-4"
      >
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-56" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-48" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-48" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-56" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-60" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-52" />
        <div class="animate-pulse h-16 bg-gray-400/70 rounded-lg w-48" />
        <div class="animate-pulse h-16 bg-gray-400 rounded-lg w-56" />
      </section>
      <section v-else-if="store.beneficiaries.length === 0">
        <no-data />
      </section>
      <section
        v-else
        class="flex flex-wrap gap-4 justify-start pb-4"
      >
        <beneficiary-card
          v-for="beneficiary in store.beneficiaries"
          :key="beneficiary.name"
          :beneficiary="beneficiary"
        />
      </section>
    </Transition>
    <beneficiary-form @store="store.addBeneficiary($event)" />
  </div>
</template>

<style scoped>
</style>
