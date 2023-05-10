<template>
  <form>
    <h2>Add a new account</h2>
    <div class="flex gap-8">
      <form-input placeholder="Name" />
      <form-input
        placeholder="Initial balance"
        type="number"
      />
      <form-input
        placeholder="Opened on date"
        type="date"
      />
      <form-input
        placeholder="Closed on date"
        type="date"
      />
    </div>
  </form>
</template>

<script setup lang="ts">
import FormInput from "./FormInput.vue";
</script>

<style scoped>

</style>
