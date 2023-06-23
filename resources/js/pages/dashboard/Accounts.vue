<template>
  <div class="flex flex-col justify-between h-full">
    <section>
      <h1>Accounts</h1>
      <Transition
        name="fade-loading"
        mode="out-in"
      >
        <div
          v-if="isLoading"
          role="status"
        >
          <div class="flex flex-wrap items-center w-full gap-4">
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-40" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-40" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-40" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-24" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-24" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-42" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80" />
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32" />
          </div>
          <span class="sr-only">Loading...</span>
        </div>
        <div v-else-if="accounts.length === 0">
          <no-data />
        </div>
        <div
          v-else
          class="flex flex-wrap gap-4"
        >
          <account-card
            v-for="account in accounts.concat(added)"
            :key="account"
            :account="account"
          />
        </div>
      </Transition>
    </section>
    <form-account @store="added.push($event)" />
  </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import AccountCard from "../../components/AccountCard.vue";
import FormAccount from "../../components/form/crud/AccountForm.vue";
import NoData from "../../components/NoData.vue";

const accounts = ref([]);
const isLoading = ref(true);
const added = ref([]);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/accounts');
    accounts.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
})
</script>

<style scoped>
</style>
