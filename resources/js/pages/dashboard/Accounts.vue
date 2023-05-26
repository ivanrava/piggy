<template>
  <div class="flex flex-col justify-between h-full">
    <section>
      <h1>Accounts</h1>
      <Transition name="fade" mode="out-in">
        <div role="status" v-if="isLoading">
          <div class="flex flex-wrap items-center w-full gap-4">
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-40"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-40"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-40"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-24"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-24"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-42"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-24"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-36"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
            <div class="animate-pulse h-14 bg-gray-400/70 rounded-lg w-80"></div>
            <div class="animate-pulse h-14 bg-gray-400 rounded-lg w-32"></div>
          </div>
          <span class="sr-only">Loading...</span>
        </div>
        <div class="flex flex-wrap gap-4" v-else>
          <account-card
            v-for="account in accounts"
            :key="account"
            :account="account"
          />
        </div>
      </Transition>
    </section>
    <form-account />
  </div>
</template>

<script setup>
// import AccountRow from "../../components/AccountRow.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import AccountCard from "../../components/AccountCard.vue";
import FormAccount from "../../components/form/crud/AccountForm.vue";

const accounts = ref([]);
const isLoading = ref(true);

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

const randomColorWidth = () => {
  const colors = ['bg-gray-400', 'bg-gray-400/60']
  const widths = ['w-32', 'w-36', 'w-24', 'w-28', 'w-40', 'w-52']
  const w = widths[Math.floor(Math.random() * widths.length)]
  const c = colors[Math.floor(Math.random() * colors.length)]
  return `${c} ${w}`;
}
</script>

<style scoped>
th {
  @apply p-2;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
