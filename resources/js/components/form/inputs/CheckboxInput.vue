<script setup lang="ts">
import {computed} from "vue";
import LabelInput from "./LabelInput.vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
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
  <label-input class="flex items-center gap-2 cursor-pointer">
    <input
      v-model="value"
      type="checkbox"
      :name="label"
      class="appearance-none bg-transparent m-0 w-6 h-6 border-2 dark:border-stone-500 dark:checked:border-pink-200 rounded-md cursor-pointer transition-all p-1 checkmark-path grid place-content-center content"
    >
    {{ label }}
  </label-input>
</template>

<style scoped>
.checkmark-path[type='checkbox']::before {
  clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
  content: '';
  @apply bg-stone-400 scale-0 w-3 h-3 transition-all duration-75;
}
.checkmark-path[type='checkbox']:checked::before {
  @apply bg-pink-200 scale-100;
}
</style>
