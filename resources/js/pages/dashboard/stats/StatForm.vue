<script setup lang="ts">
import axios from "axios";
import {useRouter} from "vue-router";
const props = defineProps<{
  title: String
  form: Object
}>()

const storeChart = () => {
  axios.post('/charts', props.form)
    .then(() => {
      useRouter().push('/charts')
    })
    .catch((error) => {
      console.log(error)
    })
}
</script>

<template>
  <form
    class="p-8 bg-stone-100 rounded-md shadow-sm"
    @submit.prevent="storeChart"
  >
    <h1 class="font-bold">
      {{ title }}
    </h1>
    <slot />
  </form>
</template>

<style scoped>

</style>
