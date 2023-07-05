<script setup lang="ts">

</script>

<template>
  <ul>
    <li>
      <router-link to="/charts">
        Your charts
      </router-link>
      <p class="text-sm font-extralight">
        Take a look at all the charts that you have previously generated.
      </p>
    </li>
    <li>
      <router-link to="/charts/create">
        Create a new chart
      </router-link>
      <p class="text-sm font-extralight">
        Define a new chart to keep track of a new statistic.
      </p>
    </li>
  </ul>
</template>

<style scoped>
ul {
  @apply text-xl font-light mx-2;
}
li {
  @apply mt-4 mb-8 pl-1 relative;
}
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
