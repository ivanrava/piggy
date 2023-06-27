<script setup lang="ts">
import {computed, ref} from "vue";
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";
import RadioInput from "../../../components/form/inputs/RadioInput.vue";

const props = defineProps({
  modelValue: {
    type: Object,
  }
})
const emit = defineEmits(['update:modelValue'])

const form = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

const options = ref([
  {id:'beneficiaries',display:'Beneficiaries'},
  {id:'categories',display:'Categories'},
])
</script>

<template>
  <p>
    This statistic shows a list of the top 5 elements for the provided domains,
    according to the global amount of money moved under the specified domain.
  </p>
  <radio-input
    v-model="form.domain"
    label="Domain"
    :options="options"
  />
  <submit-button>Add statistic</submit-button>
</template>

<style scoped>
</style>
