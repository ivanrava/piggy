<script setup lang="ts">
const props = defineProps({
  for: {
    type: String,
  },
})
</script>

<template>
  <label class="block mb-1" :for="props.for">
    <slot/>
  </label>
</template>

<style scoped>

</style>
