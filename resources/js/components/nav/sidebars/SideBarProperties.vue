<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {usePropertyStore} from "../../../composables/usePropertiesStore";

const store = usePropertyStore();
</script>

<template>
  <section>
    <h2>Your properties</h2>
    <ul>
      <li
        v-for="property in store.properties"
        :key="property"
        class="flex flex-row items-center gap-2 text-sm my-1 pl-2"
      >
        <Icon :icon="property.icon" />
        <span>{{ property.name }}</span>
      </li>
    </ul>
  </section>
</template>

<style scoped>

</style>
