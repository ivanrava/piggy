<script setup lang="ts">
import LabelInput from "./LabelInput.vue";
import VueMultiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css';
import {ref} from "vue";

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
const focused = ref(false);
</script>

<template>
  <div class="w-full">
    <label-input
      :for="name"
      class="ml-1"
      :class="{'!-top-2.5': focused, '!text-pink-200': focused}"
    >
      {{ name }}
    </label-input>
    <VueMultiselect
      :options="options"
      class="w-full rounded-md border-2 outline-none transition-all ring-0 ring-pink-300/20"
      :class="{'border-pink-200/40 ring-4': focused}"
      :model-value="options.find(t=>t.id === modelValue)"
      track-by="id"
      label="name"
      @update:model-value="emit('update:modelValue', $event.id)"
      @open="focused = true"
      @close="focused = false"
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
  padding-top: 0;
  color: #555;
  @apply font-serif;
}

.multiselect__tags {
  border: none;
  @apply bg-stone-50 text-slate-900;
}

.multiselect__single, .multiselect__input {
  @apply bg-stone-50;
  font-size: 14px;
  padding-left: 0;
}

.multiselect__input {
  @apply font-serif;
  margin-top: 2px;
}

.option__title {
  @apply font-mono;
}
</style>
