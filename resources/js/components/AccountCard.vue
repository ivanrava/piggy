<template>
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
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {Account} from '../composables/interfaces';

defineProps<{
  account: Account
}>();
</script>

<style scoped>

</style>
