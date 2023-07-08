<script setup lang="ts">
import SideBarAccountList from "./SideBarAccountList.vue";
import {useAccountsStore} from "../../composables/useAccountsStore";
import {onMounted} from "vue";
import axios from "axios";

const store = useAccountsStore();

const filterByType = (type) => {
  return store.accounts.filter(acc => acc.type == type).sort((a, b) => a.name < b.name ? -1 : 1)
}

onMounted(async () => {
  if (store.accounts.length > 0)
    return

  try {
    const res = axios.get('/accounts');
    store.setAccounts((await res).data.data);
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
})
</script>

<template>
  <section
    class="flex flex-col w-full"
  >
    <h2>Bank accounts</h2>
    <side-bar-account-list :accounts="filterByType('Bank account')" />
    <h2>Cash</h2>
    <side-bar-account-list :accounts="filterByType('Cash')" />
    <h2>Credits</h2>
    <side-bar-account-list :accounts="filterByType('Voucher')" />
    <h2>Investments</h2>
    <side-bar-account-list :accounts="filterByType('Investments')" />
  </section>
</template>

<style scoped>

</style>
