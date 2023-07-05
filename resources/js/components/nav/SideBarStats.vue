<script setup lang="ts">
import SideBarGeneric from "./SideBarGeneric.vue";

const links = [
  {
    name: 'Your charts',
    to: '/charts',
    description: 'Take a look at all the charts that you have previously generated.'
  },
  {
    name: 'Create a new chart',
    to: '/charts/create',
    description: 'Define a new chart to keep track of a new statistic.'
  }
]
</script>

<template>
  <side-bar-generic :links="links" />
</template>

<style scoped>
</style>
