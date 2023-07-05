<script setup lang="ts">
import {Icon} from "@iconify/vue";

defineProps<{
  title: string
  favorite: boolean
}>();
</script>

<template>
  <article class="p-4 bg-stone-50/90 shadow-md m-16 rounded-sm h-72 flex flex-col w-[23.5rem]">
    <div class="flex justify-between items-baseline">
      <h2>
        {{ title }}
      </h2>
      <Icon
        :icon="favorite ? 'fe:star' : 'mdi-light:star'"
        class="text-lg cursor-pointer transition-all"
        :class="favorite ? 'opacity-80 hover:opacity-90' : 'opacity-50 hover:opacity-90'"
      />
    </div>
    <div class="overflow-auto flex-grow flex justify-center items-center">
      <slot />
    </div>
  </article>
</template>

<style scoped>

</style>
