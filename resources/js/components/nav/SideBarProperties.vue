<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {usePropertyStore} from "../../composables/usePropertiesStore";

const store = usePropertyStore();
</script>

<template>
  <h2>Your properties</h2>
  <ul>
    <li
      v-for="property in store.properties"
      :key="property"
      class="flex flex-row items-center gap-2 text-lg my-1"
    >
      <Icon :icon="property.icon" />
      <span>{{ property.name }}</span>
    </li>
  </ul>
</template>

<style scoped>

</style>
