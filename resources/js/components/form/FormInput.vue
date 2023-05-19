<template>
  <div class="my-2 w-48 relative">
    <label-input
      :for="label"
      class="absolute left-2.5 top-3 text-gray-500 cursor-text transition-all px-1 bg-stone-50 rounded-t-md"
      :class="{'!-top-2.5': focused || value.length > 0, '!text-pink-200': focused}"
    >
      {{ label }}
    </label-input>
    <input
      :id="label"
      v-model="value"
      class="focus:outline-none focus:border-pink-200/40 bg-stone-50 focus:ring-4 outline-none transition-all ring-0 ring-pink-300/20 text-slate-900 p-2 border-2 w-full rounded-md text-sm font-mono"
      :name="label"
      :type="type"
      v-bind="$attrs"
      @focus="focused = true"
      @blur="focused = false"
    >
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
  </div>
</template>

<script setup lang="ts">
import {computed, ref} from "vue";
import LabelInput from "./LabelInput.vue";

const props = defineProps({
    modelValue: {
        type: String,
    },
    label: {
        type: String,
    },
    type: {
        type: String,
        default: 'text'
    },
    errors: {
        type: Array<String>,
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
