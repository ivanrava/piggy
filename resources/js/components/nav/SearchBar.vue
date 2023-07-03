<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {ref} from "vue";

const focused = ref(false);
const query = ref('');
</script>

<template>
  <label class="grow mx-32 relative cursor-pointer">
    <input
      v-model="query"
      class="w-full bg-pink-100/40 hover:bg-stone-500/10 outline-none focus:outline-none focus:ring-4 focus:ring-offset-0 focus:bg-gray-50/10 transition-all p-2 rounded-lg ring-1 ring-gray-50/30 ring-offset-1 ring-offset-pink-50 cursor-pointer text-xs"
      @focus="focused = true"
      @blur="focused = false"
      @keydown.esc="$event.target.blur()"
    >
    <span
      class="absolute left-1/2 top-1 text-slate-900 transition-all duration-300 -translate-x-1/2"
      :class="focused || query.length > 0 ? 'opacity-0' : 'opacity-60'"
    >
      <Icon
        icon="ic:round-search"
        class="inline"
      />
      Search
    </span>
  </label>
</template>

<style scoped>

</style>
