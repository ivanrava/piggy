<template>
  <div class="my-1 w-48 relative">
    <label-input
      :for="label"
      class="absolute left-2.5 top-3 transition-all px-1 bg-stone-50 rounded-t-md"
      :class="{'!-top-2.5': focused || value.length > 0, '!text-pink-200': focused}"
    >
      {{ label }}
    </label-input>
    <textarea
      :id="label"
      v-model="value"
      class="focus:outline-none transition-all ring-pink-300/20 bg-stone-50 focus:border-pink-200/40 focus:ring-4 outline-none rounded-md border-2 ring-0 p-2 w-full text-sm font-mono"
      :name="label"
      @focus="focused = true"
      @blur="focused = false"
    />
    <ul
      v-if="fullErrors.length > 0"
      class="p-2 bg-red-50 bg-opacity-30 rounded-b-md"
    >
      <li
        v-for="error in fullErrors"
        :key="error"
        class="text-left text-xs text-red-400"
      >
        <i-fa6-regular-circle-xmark class="inline" />
        {{ error }}
      </li>
    </ul>
    <span
      class="text-xs m-2"
      :class="value.length > maxLength ? 'text-red-400' : 'text-stone-600'"
    >
      {{ value.length }} / {{ maxLength }} characters
    </span>
  </div>
</template>

<script setup lang="ts">
import {computed, ref} from "vue";
import LabelInput from "./LabelInput.vue";

const maxLength = 500;
const props = defineProps({
    modelValue: {
        type: String,
    },
    label: {
        type: String,
    },
    errors: {
        type: Array<String>,
        default: []
    }
})
const emit = defineEmits(['update:modelValue'])

const value = computed({
    get() {
        return props.modelValue === null ? '' : props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})

const focused = ref(false);

const validators = {
  email: {
    'Please insert a correct email address': (email) => {
      const emailRegex = new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, "gm")
      return emailRegex.test(email)
    }
  }
}

const fullErrors = computed<Array<String>>(() => {
  const myErrors = [];
  if (props.type in validators) {
    for (const [message, validator] of Object.entries(validators[props.type])) {
      if (validator(value))
        myErrors.push(message)
    }
  }

  return props.errors
});
</script>
