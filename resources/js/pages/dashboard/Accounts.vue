<template>
  <table class="table">
    <thead>
      <tr class="text-xl border-b-2">
        <th class="text-left">
          Account
        </th>
        <th class="text-right">
          Balance
        </th>
      </tr>
    </thead>
    <tbody>
      <account-row
        v-for="account in accounts"
        :key="account.name"
        :account="account"
      />
    </tbody>
  </table>
</template>

<script setup>
import AccountRow from "../../components/AccountRow.vue";
import {onMounted, ref} from "vue";
import axios from "axios";

const accounts = ref([]);
const isLoading = ref(false);

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
th {
  @apply p-2;
}
</style>
