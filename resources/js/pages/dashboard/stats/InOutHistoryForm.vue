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
  {id:'month',display:'Monthly'},
  {id:'year',display:'Yearly'},
])
</script>

<template>
  <p>
    Through this component you can easily gauge your expenses and incomes trends.
  </p>
  <radio-input
    v-model="form.interval"
    label="Interval"
    :options="options"
  />
  <submit-button>Add statistic</submit-button>
</template>

<style scoped>

</style>
