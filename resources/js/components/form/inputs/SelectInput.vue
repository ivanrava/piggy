<script setup lang="ts">
import LabelInput from "./LabelInput.vue";
import VueMultiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css';
import {ref} from "vue";
import {Icon} from "@iconify/vue";
import ErrorList from "./ErrorList.vue";

defineProps({
  modelValue: {
    type: Number,
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
  },
  errors: {
    type: Array<String>,
    default: []
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
    <error-list :errors="errors" />
  </div>
</template>

<style>
.multiselect__tag {
  @apply bg-pink-300;
}

.multiselect__option--highlight {
  @apply bg-pink-300 dark:bg-pink-600;
}

.multiselect__option--highlight:after {
  @apply bg-pink-300 dark:bg-pink-600;
}

.multiselect__option--selected.multiselect__option--highlight {
  @apply bg-slate-400 dark:bg-slate-700;
}

.multiselect__option--selected.multiselect__option--highlight:after {
  @apply bg-slate-400 dark:bg-slate-700;
}

.multiselect__option--selected {
  @apply dark:bg-stone-700 dark:text-stone-100;
}

.multiselect__option--selected:after {
  @apply dark:bg-stone-700 dark:text-stone-100;
}

.multiselect__tag-icon:hover {
  @apply bg-pink-300 dark:bg-pink-600;
}

.multiselect__placeholder {
  padding-top: 0;
  color: #555;
  @apply font-serif dark:text-stone-200/50;
}

.multiselect__tags {
  @apply bg-stone-50 text-slate-900 border-0 bg-transparent;
}

.multiselect__single, .multiselect__input {
  @apply bg-stone-50 dark:bg-transparent dark:text-stone-100;
  font-size: 14px;
}

.multiselect__input {
  @apply font-serif dark:bg-transparent dark:text-stone-200/50;
  margin-top: 2px;
}

.multiselect__element {
  @apply bg-transparent;
}

.multiselect__content-wrapper {
  @apply dark:bg-stone-900 dark:border-[1px] dark:border-stone-700;
}

.option__title {
  @apply font-mono;
}

.multiselect {
  @apply dark:border-[1px] dark:border-stone-200/50 dark:text-stone-100;
}
</style>
