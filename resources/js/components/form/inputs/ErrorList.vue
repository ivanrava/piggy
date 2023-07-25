<script setup lang="ts">
defineProps<{
  errors: Array<String>
}>()
</script>

<template>
  <ul
    v-if="errors.length > 0"
    class="p-2 bg-red-50/30 dark:bg-red-800/10 rounded-b-md"
  >
    <li
      v-for="error in errors"
      :key="error"
      class="text-left text-xs text-red-400"
    >
      <i-fa6-regular-circle-xmark class="inline" />
      {{ error }}
    </li>
  </ul>
</template>

<style scoped>

</style>
