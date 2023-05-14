<script setup lang="ts">
import {computed} from "vue";
import FormInput from "./FormInput.vue";
import {useCurrencyInput} from "vue-currency-input";

const props = defineProps({
  modelValue: {
    type: Number,
  },
  name: {
    type: String,
  },
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

const {inputRef} = useCurrencyInput({
  currency: "EUR",
  valueRange: {
    min: 0,
    max: 99999999.99
  },
  precision: 2,
  hideCurrencySymbolOnFocus: true,
  hideGroupingSeparatorOnFocus: true,
  hideNegligibleDecimalDigitsOnFocus: true,
  autoDecimalDigits: false,
  useGrouping: true,
  accountingSign: false
})
</script>

<template>
  <form-input
    ref="inputRef"
    v-model.number="value"
    type="text"
    :name="name"
  />
</template>

<style scoped>

</style>
