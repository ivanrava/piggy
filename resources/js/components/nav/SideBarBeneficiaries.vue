<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import BeneficiaryCard from "../BeneficiaryCard.vue";

const beneficiaries = ref([]);
onMounted(() => {
  axios.get('/beneficiaries').then(({data}) => {
    beneficiaries.value = data.data;
  })
})
</script>

<template>
  <beneficiary-card
    v-for="beneficiary in beneficiaries"
    :key="beneficiary.id"
    :beneficiary="beneficiary"
    :hide-bg="true"
    :small="true"
    class="opacity-50 hover:opacity-100"
  />
</template>

<style scoped>

</style>
