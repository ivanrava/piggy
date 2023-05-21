<script setup lang="ts">
const props = defineProps({
  for: {
    type: String,
  },
})
</script>

<template>
  <label
    class="block mb-0.5 font-bold tracking-wide text-sm font-serif text-gray-500"
    :for="props.for"
  >
    <slot />
  </label>
</template>
