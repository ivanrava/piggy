<script setup lang="ts">
import axios from "axios";
import {useRouter} from "vue-router";
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";
import {ref} from "vue";
const props = defineProps<{
  title: String
  form: Object
}>()

const router = useRouter();
const loading = ref(false);
const storeChart = () => {
  loading.value = true;
  axios.post('/charts', props.form)
    .then(() => {
      router.push('/charts')
    }).catch((error) => {
      console.log(error)
    }).finally(() => {
      loading.value = false;
    })
}
</script>

<template>
  <form
    class="p-8 bg-stone-100 dark:bg-pink-950/40 rounded-md shadow-sm"
    @submit.prevent="storeChart"
  >
    <h1 class="font-bold">
      {{ title }}
    </h1>
    <slot />
    <submit-button
      class="!mt-4 md:m-auto w-full"
      :is-loading="loading"
    >
      Add statistic
    </submit-button>
  </form>
</template>

<style scoped>

</style>
