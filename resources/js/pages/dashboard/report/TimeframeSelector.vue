<script setup lang="ts">
import FormInput from "../../../components/form/inputs/FormInput.vue";
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";
import {ref} from "vue";

const form = ref({
  from: '',
  to: ''
})

defineProps<{
  isLoading: boolean
}>();

defineEmits(['submit'])
</script>

<template>
  <form
    class="bg-stone-100 dark:bg-stone-900 p-4 rounded-lg my-4 shadow-sm print:hidden"
    @submit.prevent="$emit('submit', form)"
  >
    <h2>Customize your report</h2>
    <p class="my-2 text-slate-900 dark:text-stone-400">
      Choose the timeframe of the operations which you would like to capture using the controls below. Leave the fields empty if you want to avoid specifying an explicit timeframe.
    </p>
    <div class="flex flex-col md:flex-row justify-start gap-2 md:gap-8">
      <form-input
        v-model="form.from"
        label="From"
        type="date"
      />
      <form-input
        v-model="form.to"
        label="To"
        type="date"
      />
      <submit-button :is-loading="isLoading">
        Submit
      </submit-button>
    </div>
  </form>
</template>

<style scoped>

</style>
