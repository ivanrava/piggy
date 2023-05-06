<template>
  <tr>
    <td class="flex items-center pt-2 pl-1">
      <account-card :account="account" />
    </td>
    <td class="text-right">
      <span class="text-xl">{{ account.balance }}</span>
      <br>
      <small class="text-stone-400">{{ account.last_update }}</small>
    </td>
  </tr>
</template>

<script setup lang="ts">
import AccountCard from "./AccountCard.vue";
import {Account} from '../composables/interfaces';

defineProps<{
  account: Account
}>();
</script>

<style scoped>

</style>
