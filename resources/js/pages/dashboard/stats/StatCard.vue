<script setup lang="ts">
defineProps<{
  title: String
}>();
</script>

<template>
  <article class="p-4 bg-stone-50/90 shadow-md m-16 rounded-sm h-64 flex flex-col w-96">
    <h2>
      {{ title }}
    </h2>
    <slot />
  </article>
</template>

<style scoped>

</style>
