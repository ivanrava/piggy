<script setup lang="ts">
import {Account} from "../../composables/interfaces";
import {Icon} from "@iconify/vue";

defineProps<{
  accounts: Array<Account>
}>();
</script>

<template>
  <div
    v-for="account in accounts"
    :key="account.id"
    class="my-0.5 w-full relative text-stone-900"
  >
    <span class="absolute right-0 z-10 pr-2 py-1.5 cursor-pointer">
      <Icon icon="fluent:delete-16-regular" />
    </span>
    <span class="absolute right-6 z-10 pr-2 py-1.5 cursor-pointer">
      <Icon icon="radix-icons:pencil-1" />
    </span>
    <div
      class="flex items-center px-2 py-1 rounded-sm hover:shadow-sm transition-all cursor-pointer"
      :style="{backgroundColor: `#${account.color}33`}"
    >
      <Icon
        :icon="account.icon"
        class="mr-1"
      />
      <span class="font-medium text-sm tracking-tighter">{{ account.name }}</span>
    </div>
  </div>
</template>

<style scoped>

</style>
