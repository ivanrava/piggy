<template>
  <table class="table">
    <thead>
      <tr class="text-xl border-b-2">
        <th class="text-left">Account</th>
        <th class="text-right">Balance</th>
      </tr>
    </thead>
    <tbody>
      <account-row v-for="account in accounts" :account="account" />
    </tbody>
  </table>
</template>

<script setup>
import AccountRow from "../../components/AccountRow.vue";
import {ref} from "vue";

const accounts = ref([
]);
</script>

<style scoped>
th {
  @apply p-2;
}
</style>
