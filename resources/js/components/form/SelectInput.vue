<script setup lang="ts">
import {computed} from "vue";
import LabelInput from "./LabelInput.vue";

const props = defineProps({
  modelValue: {
    type: String,
  },
  placeholder: {
    type: String,
    default: null
  },
  name: {
    type: String,
  },
  label: {
    type: String,
    default: null
  },
  options: {
    type: Array<Object>,
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
  <div class="my-1">
    <label-input :for="name">{{ name }}</label-input>
    <select
      :name="name"
      class="focus:outline-none transition-all ring-pink-300/20 focus:ring-4 p-2 bg-slate-100 w-48 rounded-sm text-sm font-mono"
      v-model="value"
    >
      <option disabled value="">Please select one</option>
      <option v-for="option in options" :value="option.value">
        {{ option.option }}
      </option>
    </select>
  </div>
</template>

<style scoped>

</style>
