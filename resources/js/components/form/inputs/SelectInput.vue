<script setup lang="ts">
import LabelInput from "./LabelInput.vue";
import VueMultiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css';

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
  <div class="w-full">
    <label-input
      :for="name"
      class="ml-1"
    >
      {{ name }}
    </label-input>
    <VueMultiselect
      :options="options"
      class="w-full rounded-md border-2"
      :model-value="options.find(t=>t.id === modelValue)"
      track-by="id"
      label="name"
      @update:model-value="emit('update:modelValue', $event.id)"
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

<style>
.multiselect__tag {
  @apply bg-pink-300;
}

.multiselect__option--highlight {
  @apply bg-pink-300;
}

.multiselect__option--highlight:after {
  @apply bg-pink-300;
}

.multiselect__option--selected.multiselect__option--highlight {
  background: #798b91;
}

.multiselect__option--selected.multiselect__option--highlight:after {
  background: #798b91;
}

.multiselect__tag-icon:hover {
  @apply bg-pink-300;
}

.multiselect__placeholder {
  color: #999999;
}
</style>
