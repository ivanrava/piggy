<script setup lang="ts">
import {computed} from "vue";

const props = defineProps({
  modelValue: {
    type: String,
  },
  label: {
    type: String,
  },
  options: {
    type: Array<{
      id: String,
      display: String
    }>
  },
  errors: {
    type: Array<String>,
    default: []
  }
})
const emit = defineEmits(['update:modelValue'])

const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})
</script>

<template>
  <div class="flex flex-col">
    <div class="font-bold mt-2 text-lg mb-1">
      {{ label }}
    </div>
    <div class="flex gap-4 mb-2">
      <span
        v-for="option in options"
        :key="option.id"
      >
        <input
          :id="option.id+label"
          v-model="value"
          type="radio"
          :value="option.id"
          class="mr-1"
        >
        <label
          :for="option.id+label"
          class="cursor-pointer"
        >
          {{ option.display }}
        </label>
      </span>
    </div>
  </div>
</template>

<style scoped>

</style>
