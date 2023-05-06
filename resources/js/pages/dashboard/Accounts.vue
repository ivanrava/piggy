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
  {
    icon: 'fluent:wallet-credit-card-16-filled',
    name: 'Wallet',
    type: 'Cash',
    balance: '300€',
    last_update: 'Last update 3 minutes ago',
    color: '#00BFA6',
  },
  {
    icon: 'vaadin:handshake',
    name: 'TFR DiRete',
    type: 'Investments',
    balance: '224€',
    last_update: 'Last update 16 minutes ago',
    color: '#F9A826',
  }
]);
</script>

<style scoped>
th {
  @apply p-2;
}
</style>
