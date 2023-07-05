<script setup lang="ts">
defineProps<{
  title: String
}>();
</script>

<template>
  <article class="p-4 bg-stone-50/90 shadow-md m-16 rounded-sm h-72 flex flex-col w-[23.5rem]">
    <h2>
      {{ title }}
    </h2>
    <div class="overflow-auto flex-grow flex justify-center items-center">
      <slot />
    </div>
  </article>
</template>

<style scoped>

</style>
