<script setup lang="ts">
defineProps<{
  links: Array<{
    name: string,
    to: string,
    description: string
  }>
}>()
</script>

<template>
  <ul
    class="text-xl font-light mx-2"
  >
    <li
      v-for="link in links"
      :key="link.to"
      class="mt-4 mb-8 pl-1 relative"
    >
      <router-link :to="link.to">
        {{ link.name }}
      </router-link>
      <p class="text-sm font-extralight">
        {{ link.description }}
      </p>
    </li>
  </ul>
</template>

<style scoped>
a.router-link-active::before {
  content: '';
  @apply w-2 h-2 rounded-full bg-pink-300 block absolute right-full top-2.5;
}
a::before {
  content: '';
  @apply w-2 h-2 rounded-full bg-pink-300/10 border-pink-300 border-[1px] block absolute right-full top-2.5 transition-all;
}
a.router-link-active {
  @apply font-medium;
}
</style>
