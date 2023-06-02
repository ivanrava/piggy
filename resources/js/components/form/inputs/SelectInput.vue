<script setup lang="ts">
import LabelInput from "./LabelInput.vue";
import VueMultiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css';
import {ref} from "vue";
import {Icon} from "@iconify/vue";

defineProps({
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
  },
  taggable: {
    type: Boolean,
    default: false
  },
  tagPlaceholder: {
    type: String,
    default: ''
  },
  allowEmpty: {
    type: Boolean,
    default: false
  }
})
const emit = defineEmits(['update:modelValue', 'tag'])
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
      :allow-empty="allowEmpty"
      track-by="id"
      label="name"
      :taggable="taggable"
      :tag-placeholder="tagPlaceholder"
      deselect-label=""
      @update:model-value="emit('update:modelValue', $event !== null ? $event.id : null)"
      @open="focused = true"
      @close="focused = false"
      @tag="$emit('tag', $event)"
    >
      <template #singleLabel="props">
        <slot :option="props.option">
          <span class="option__title">{{ props.option.name }}</span>
        </slot>
      </template>
      <template #option="props">
        <slot
          v-if="props.option.name !== undefined"
          :option="props.option"
        >
          <span class="option__title">{{ props.option.name }}</span>
        </slot>
        <span
          v-else
          class="option__title"
        >{{ props.option.label }}</span>
      </template>
      <template #noResult="props">
        <span class="option__title">
          <Icon
            icon="ri:emotion-sad-line"
            class="inline"
          />
          No elements found.
        </span>
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
