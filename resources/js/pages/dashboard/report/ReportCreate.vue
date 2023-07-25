<script setup lang="ts">
import {ref} from "vue";
import axios from "axios";
import {Category} from "../../../composables/interfaces";
import FormInput from "../../../components/form/inputs/FormInput.vue";
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";
import ReportCategories from "./ReportCategories.vue";

const form = ref({
  from: '',
  to: ''
})
const inCategories = ref<Array<Category>>([]);
const outCategories = ref<Array<Category>>([]);
const fetched = ref(false);
const fetchReport = (form) => {
  axios.get('/report', {
    params: {
      from: form.from,
      to: form.to,
    }
  }).then(({data}) => {
    inCategories.value = data.in
    outCategories.value = data.out
    fetched.value = true;
    setTimeout(() => {
      window.print();
    }, 1000)
  })
}

</script>

<template>
  <h1 class="print:hidden">
    Report by categories
  </h1>
  <form
    class="bg-stone-100 dark:bg-stone-900 p-4 rounded-lg my-4 shadow-sm print:hidden"
    @submit.prevent="fetchReport(form)"
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
      <submit-button>
        Submit
      </submit-button>
    </div>
  </form>
  <report-categories
    v-if="fetched"
    :in-categories="inCategories"
    :out-categories="outCategories"
  />
  <div
    v-else
    class="flex flex-col items-center gap-8 justify-center w-full p-8 my-16"
  >
    <img
      class="w-2/3 md:w-1/3"
      src="/investment.svg"
      alt="No data"
    >
    <span class="block text-stone-600 text-center dark:text-stone-200/50">
      Your report will be loaded right here. Fill the form and it will <i class="tracking-wide md:tracking-widest">automagically</i> appear.
    </span>
  </div>
</template>

<style scoped>

</style>
