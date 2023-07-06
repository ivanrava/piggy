<template>
  <div class="flex flex-col justify-between h-full">
    <section class="pb-4 overflow-scroll h-full">
      <h1 class="mt-0 md:mt-4 text-3xl">
        Accounts
      </h1>
      <Transition
        name="fade-loading"
        mode="out-in"
      >
        <div
          v-if="isLoading"
          role="status"
        >
          <div class="h-full flex md:flex-wrap md:items-center w-full gap-4 flex-col items-stretch md:flex-row">
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-24" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-40" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-40" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-40" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-24" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-80" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-24" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-24" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-36" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-36" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-80" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-44" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-24" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-36" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
            <div class="w-full animate-pulse h-14 bg-gray-400/70 rounded-lg md:w-80" />
            <div class="w-full animate-pulse h-14 bg-gray-400 rounded-lg md:w-32" />
          </div>
          <span class="sr-only">Loading...</span>
        </div>
        <div
          v-else-if="store.accounts.length !== 0"
          class="h-full md:h-auto flex gap-4 items-stretch flex-col md:flex-row md:items-center md:flex-wrap"
        >
          <div
            v-for="account in store.accounts"
            :key="account.id"
            class="flex items-center gap-4"
          >
            <account-card
              class="w-full"
              :account="account"
              :class="{'opacity-20': askedForDeletion === account.id}"
            />
            <Icon
              icon="fluent:delete-16-regular"
              class="text-2xl mr-4 cursor-pointer opacity-60 hover:opacity-100 transition-all block md:hidden"
              :class="{'text-red-700 opacity-90': askedForDeletion === account.id}"
              @click="askDelete(account)"
            />
          </div>
        </div>
        <div v-else>
          <no-data />
        </div>
      </Transition>
    </section>
    <account-form
      @store="store.addAccount($event)"
      @update="store.updateAccount($event)"
    />
  </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import AccountCard from "../../../components/AccountCard.vue";
import AccountForm from "../../../components/form/crud/AccountForm.vue";
import NoData from "../../../components/NoData.vue";
import {useAccountsStore} from "../../../composables/useAccountsStore";
import {Icon} from "@iconify/vue";

const store = useAccountsStore();

const isLoading = ref(true);
onMounted(async () => {
  if (store.accounts.length > 0)
    isLoading.value = false;

  isLoading.value = true;
  axios.get('/accounts')
    .then(({data}) => {
      store.setAccounts(data.data);
    }).finally(() => {
      isLoading.value = false;
  })
})

const askedForDeletion = ref(null);
const askDelete = (account) => {
  if (askedForDeletion.value === account.id)
    axios.delete(`/accounts/${account.id}`)
      .then(() => {
        store.deleteAccount(account)
      })
      .catch((res) => {
        console.log(res)
      })

  askedForDeletion.value = account.id;
}
</script>

<style scoped>
</style>
