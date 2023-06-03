<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";

const transactions = ref({})
onMounted(() => {
  axios.get('/report', {
    params: {
      from: '2000-01-01',
      to: '2023-01-01',
      sort: 'amount',
      direction: 'desc'
    }
  }).then(({data}) => {
    transactions.value = data
  })
})
</script>

<template>
  <pre>
    {{ transactions }}
  </pre>
</template>

<style scoped>

</style>
