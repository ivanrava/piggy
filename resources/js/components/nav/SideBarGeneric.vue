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
    class="text-sm lg:text-xl font-light lg:mx-2 mx-1 flex justify-between md:block rounded-xl md:rounded-none"
  >
    <li
      v-for="link in links"
      :key="link.to"
      class="md:mt-4 md:mb-8 md:pl-2 md:relative"
    >
      <router-link :to="link.to">
        {{ link.name }}
      </router-link>
      <p class="text-sm font-extralight hidden md:block">
        {{ link.description }}
      </p>
    </li>
  </ul>
</template>

<style scoped>
a.router-link-active::before {
  content: '';
  @apply rounded-full bg-pink-300 block absolute right-full top-2.5;
}
a::before {
  content: '';
  @apply lg:w-2 lg:h-2 w-1 h-1 rounded-full bg-pink-300/10 border-pink-300 border-[1px] block absolute right-full top-2.5 transition-all;
}
a.router-link-active {
  @apply font-semibold lg:font-medium;
}
</style>
