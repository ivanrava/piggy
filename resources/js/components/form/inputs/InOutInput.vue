<script setup lang="ts">
import {computed} from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
  },
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
  <label
    class="inline-flex items-center cursor-pointer mt-6"
    @click="value = !value"
  >
    <span class="mx-2 text-sm font-serif text-gray-500">To</span>
    <div
      class="w-12 h-6 rounded-full relative transition-all duration-300"
      :class="value ? 'bg-red-800/50' : 'bg-green-800/50'"
    >
      <div
        class="absolute h-6 w-6 bg-white rounded-full border-[1px] transition-all"
        :class="value ? 'left-0 border-red-900/30' : 'left-1/2 border-green-900/30'"
      />
    </div>
    <span class="mx-2 text-sm font-serif text-gray-500">From</span>
  </label>
</template>

<style scoped>

</style>
