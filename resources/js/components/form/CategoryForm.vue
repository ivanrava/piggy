<script setup lang="ts">
import FormInput from "./FormInput.vue";
import IconInput from "./IconInput.vue";
import SelectInput from "./SelectInput.vue";

const optionsType = [
  {
    option: 'Out',
    value: 'out'
  },
  {
    option: 'In',
    value: 'in'
  }
]
</script>

<template>
  <form>
    <h2>Add a new category</h2>
    <form-input placeholder="Name" />
    <select-input label="Type" :options="optionsType" />
    <icon-input />
  </form>
</template>

<style scoped>

</style>
