<template>
  <div class="my-2 w-full md:w-48 relative">
    <label-input
      :for="label"
      class="z-10 absolute left-2.5 top-3 text-stone-500 dark:text-stone-200/50 cursor-text transition-all px-1 bg-stone-50 dark:bg-stone-900 rounded-t-md"
      :class="{'!-top-2.5': focused || isFieldNonEmpty, '!text-pink-200 dark:!text-pink-100': focused}"
    >
      {{ label }}
    </label-input>
    <Icon
      v-if="(type === 'password' || type === 'pw-show') && label.toLowerCase().indexOf('confirm') === -1"
      :icon="showPassword ? 'mingcute:eye-fill' : 'mingcute:eye-close-fill'"
      class="absolute right-2.5 top-3 cursor-pointer transition-all hover:text-stone-600"
      :class="showPassword ? 'text-stone-500' : 'text-stone-400'"
      @click="showPassword = !showPassword; type = type == 'pw-show' ? 'password' : 'pw-show'"
    />
    <Icon
      v-else-if="type !== 'date' && type !== 'textDecimal'"
      class="absolute right-2.5 top-3 text-stone-400"
      :icon="icon"
    />
    <input
      :id="label"
      v-model="value"
      class="focus:outline-none focus:border-pink-200/40 bg-stone-50 dark:bg-transparent focus:ring-4 outline-none transition-all ring-0 ring-pink-300/20 dark:ring-pink-100 text-slate-900 dark:text-stone-300 py-2 pl-2 border-2 dark:border-[0.5px] dark:border-stone-200/50 w-full rounded-md text-sm font-mono"
      :class="type !== 'date' && type !== 'textDecimal' ? 'pr-8' : 'pr-2'"
      :name="label"
      :type="type"
      @focus="focused = true"
      @blur="focused = false"
    >
    <error-list :errors="fullErrors" />
  </div>
</template>

<script setup lang="ts">
import {computed, ref} from "vue";
import {Icon} from "@iconify/vue";
import LabelInput from "./LabelInput.vue";
import ErrorList from "./ErrorList.vue";

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
    forceUp: {
      type: Boolean,
      default: false,
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

const isFieldNonEmpty = computed(() => {
  return props.forceUp || value.value.length > 0 || props.type === 'date';
})
const focused = ref(false);
const showPassword = ref(false);
const icon = computed(() => {
  const icons = {
    'text': props.forceUp ? '' : 'ph:text-aa-bold',
    'email': 'ion:mail-outline'
  }
  return icons[props.type];
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
