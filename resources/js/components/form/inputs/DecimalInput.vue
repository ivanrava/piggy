<script lang="ts">
import FormInput from "./FormInput.vue";
import { useCurrencyInput } from "vue-currency-input";

export default {
  name: "ElCurrencyInput",
  components: {FormInput},
  props: {
    modelValue: Number,
    name: String,
  },
  setup() {
    const { inputRef, formattedValue } = useCurrencyInput({
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
    });

    return { inputRef, formattedValue };
  },
};
</script>

<template>
  <form-input
    ref="inputRef"
    v-model="formattedValue"
    type="text"
    :name="name"
    :force-up="true"
  />
</template>

<style scoped>

</style>
