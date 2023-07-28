<script setup lang="ts">
const props = defineProps({
  for: {
    type: String,
  },
})
</script>

<template>
  <label
    class="block mb-0.5 font-bold tracking-wide text-sm font-serif text-stone-500 dark:text-stone-200/50"
    :for="props.for"
  >
    <slot />
  </label>
</template>
