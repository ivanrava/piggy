<script setup lang="ts">
import LabelInput from "./LabelInput.vue";
import {Icon} from "@iconify/vue";
import VueMultiselect from "vue-multiselect";

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
</script>

<template>
  <div class="my-1 w-full">
    <label-input :for="name">{{ name }}</label-input>
    <VueMultiselect
      :options="options"
      class="w-full"
      :model-value="options.find(t=>t.id === modelValue)"
      @update:model-value="emit('update:modelValue', $event.id)"
      track-by="id"
      label="name"
    >
      <template #singleLabel="props">
        <slot :option="props.option">
          <span class="option__title">{{ props.option.name }}</span>
        </slot>
      </template>
      <template #option="props">
        <slot :option="props.option">
          <span class="option__title">{{ props.option.name }}</span>
        </slot>
      </template>
    </VueMultiselect>
  </div>
</template>

<style scoped>

</style>
