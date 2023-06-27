<script setup lang="ts">
defineProps<{
  title: String
}>()
</script>

<template>
  <form class="p-8 bg-stone-100 rounded-md shadow-sm">
    <h1 class="font-bold">
      {{ title }}
    </h1>
    <slot />
  </form>
</template>

<style scoped>

</style>
