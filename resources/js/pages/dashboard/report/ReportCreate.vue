<script setup lang="ts">
import {ref} from "vue";
import axios from "axios";
import TimeframeSelector from "./TimeframeSelector.vue";

const fetched = ref(false);
const loading = ref(false);
const localForm = ref({from:'',to:''});

const fetchedData = ref();
const fetchReport = (form: { from: any; to: any; }) => {
  localForm.value = form;
  loading.value = true;
  axios.get(props.url, {
    params: {
      from: form.from,
      to: form.to,
    }
  }).then(({data}) => {
    fetchedData.value = data;
    fetched.value = true;
    setTimeout(() => {
      window.print();
    }, 1000)
  }).finally(() => {
    loading.value = false;
  })
}

const props = defineProps<{
  title: string,
  url: string
}>()
</script>

<template>
  <h1 class="print:hidden">
    {{ title }}
  </h1>
  <TimeframeSelector
    :is-loading="loading"
    @submit="(form) => fetchReport(form)"
  />
  <slot
    v-if="fetched"
    :fetched-data="fetchedData"
    :from="localForm.from"
    :to="localForm.to"
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
