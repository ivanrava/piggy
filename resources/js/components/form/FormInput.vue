<template>
  <div class="my-1 w-48">
    <label-input :for="name">{{ name }}</label-input>
    <input
      class="focus:outline-none transition-all ring-pink-300/20 focus:ring-4 p-2 bg-slate-100 w-full rounded-t-sm text-sm font-mono"
      :class="{'rounded-b-sm': fullErrors.length == 0}"
      v-model="value"
      :placeholder="placeholder"
      :name="name"
      :type="type"
      :id="name"
    >
    <ul class="p-2 bg-red-50 bg-opacity-30 rounded-b-md" v-if="fullErrors.length > 0">
      <li
        v-for="error in fullErrors"
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
import LabelInput from "./LabelInput.vue";

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
