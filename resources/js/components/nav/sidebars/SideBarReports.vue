<script setup lang="ts">
import SideBarGeneric from "./SideBarGeneric.vue";

const links = [
  {
    name: 'Categories',
    to: '/report/categories',
    description: 'Get a glimpse of the categories. Expenses VS Incomes'
  },
  {
    name: 'Accounts',
    to: '/report/accounts',
    description: 'Builds a summary of the accounts. Starting balance and end balance.'
  },
  {
    name: 'Properties',
    to: '/report/properties',
    description: 'Builds a summary of the properties. Starting value and end value.'
  }
]
</script>

<template>
  <section>
    <side-bar-generic :links="links" />
<!--    <p class="text-sm tracking-tighter text-center text-stone-900/60 my-32">-->
<!--      Looking for more reports?-->
<!--      Did you know that most of the pages are <i>printable by default</i>?-->
<!--      <br>-->
<!--      Hit that pesky <span class="font-mono">Ctrl-P</span> and see for yourself.-->
<!--    </p>-->
  </section>
</template>

<style scoped>

</style>
