<template>
  <div class="my-1">
    <input
      class="focus:outline-none transition-all ring-pink-300/20 focus:ring-4 p-2 bg-slate-100 w-64 rounded-t-sm text-sm font-mono"
      :class="{'rounded-b-sm': errors.length == 0}"
      v-model="value"
      :placeholder="placeholder"
      :name="name"
      :type="type"
    >
    <ul class="p-2 bg-red-50 bg-opacity-30 rounded-b-md" v-if="errors.length > 0">
      <li
        v-for="error in errors"
        class="text-left text-xs text-red-400"
      >
        <i-fa6-regular-circle-xmark class="inline" />
        {{ error }}
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import {computed} from "vue";

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
    type: {
        type: String,
        default: 'text'
    },
    errors: {
        type: Array,
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
