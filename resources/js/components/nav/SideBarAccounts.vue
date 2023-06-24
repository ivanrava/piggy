<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import SideBarAccountList from "./SideBarAccountList.vue";

const accounts = ref([]);
onMounted(() => {
  axios.get('/accounts').then(({data}) => {
    accounts.value = data.data;
  })
})

const filterByType = (type) => {
  return accounts.value.filter(acc => acc.type == type).sort((a, b) => a.name < b.name ? -1 : 1)
}
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
    <side-bar-account-list :accounts="filterByType('Credits')" />
    <h2>Investments</h2>
    <side-bar-account-list :accounts="filterByType('Investments')" />
  </section>
</template>

<style scoped>

</style>
