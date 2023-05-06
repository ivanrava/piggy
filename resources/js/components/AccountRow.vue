<template>
  <tr>
    <td class="flex items-center pt-2 pl-1">
      <article
        class="flex items-center text-slate-50 p-2 rounded-lg drop-shadow-xl cursor-pointer"
        :style="{backgroundColor: account.color}"
      >
        <Icon :icon="account.icon" class="text-4xl" />
        <div class="flex flex-col ml-2">
          <b>{{ account.name }}</b>
          <small class="text-stone-100 font-light">{{ account.type }}</small>
        </div>
      </article>
    </td>
    <td class="text-right">
      <span class="text-xl">{{ account.balance }}</span>
      <br>
      <small class="text-stone-400">{{ account.last_update }}</small>
    </td>
  </tr>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";

interface Account {
  icon: string;
  name: string;
  type: string;
  balance: string;
  last_update: string;
  color: string;
}

defineProps<{
  account: Account
}>();
</script>

<style scoped>

</style>
