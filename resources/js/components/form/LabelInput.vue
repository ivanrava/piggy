<script setup lang="ts">
const props = defineProps({
  for: {
    type: String,
  },
})
</script>

<template>
  <label class="block mb-2 font-bold tracking-wide text-sm" :for="props.for">
    <slot/>
  </label>
</template>

<style scoped>

</style>
