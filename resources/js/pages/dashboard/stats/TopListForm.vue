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

const optionsDomain = ref([
  {id:'beneficiaries',display:'Beneficiaries'},
  {id:'categories',display:'Categories'},
  {id:'accounts',display:'Accounts'},
])
const optionsStats = ref([
  {id:'sum',display:'Sum'},
  {id:'count',display:'Count'},
  {id:'avg',display:'Average'},
  {id:'max',display:'Maximum'},
])
const optionsInterval = ref([
  {id:'all',display:'All time'},
  {id:'year',display:'Last year'},
  {id:'month',display:'Last month'},
])
</script>

<template>
  <p>
    This statistic shows a list of the top 5 elements for the provided domains,
    according to the global amount of money moved under the specified domain.
  </p>
  <div class="flex md:gap-16 gap-0 flex-col md:flex-row">
    <radio-input
      v-model="form.interval"
      label="Timeframe"
      :options="optionsInterval"
    />
    <radio-input
      v-model="form.filter"
      label="Domain"
      :options="optionsDomain"
    />
    <radio-input
      v-model="form.stat"
      label="Statistic"
      :options="optionsStats"
    />
  </div>
</template>

<style scoped>
</style>
