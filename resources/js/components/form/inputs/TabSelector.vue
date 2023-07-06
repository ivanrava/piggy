<script setup lang="ts">
import {computed} from "vue";

const props = defineProps<{
  tabs: Array<{
    id: String,
    type: String
  }>,
  modelValue: String,
}>()
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
  <div class="button-group">
    <button
      v-for="tab in tabs"
      :key="tab.id"
      class="mx-1 md:m-2 pb-1 border-pink-100/20 text-pink-700/70 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700 text-sm md:text-base"
      :class="{'!border-pink-700 !text-pink-950 !font-normal': value === tab.id}"
      @click="value = tab.id"
    >
      {{ tab.type }}
    </button>
  </div>
</template>

<style scoped>

</style>
