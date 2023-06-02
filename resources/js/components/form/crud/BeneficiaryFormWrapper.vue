<script setup lang="ts">
import {ref} from "vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import BeneficiaryForm from "./BeneficiaryForm.vue";

const showForm = ref(false);

interface StoreBeneficiaryPayload {
  name: string;
  img: string;
}

const loading = ref(false);
const errors = ref({});
const storeBeneficiary = function (payload: StoreBeneficiaryPayload) {
  loading.value = true;
  axios.post("/beneficiaries", payload).then(() => {
    showForm.value = false;
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
</script>

<template>
  <beneficiary-form
    :show-form="showForm"
    :errors="errors"
    @store="(form) => storeBeneficiary(form)"
    @close="showForm = false"
  />
  <submit-button
    class="fixed right-12 bottom-12 flex items-center shadow-lg"
    @click="showForm = true"
  >
    <Icon
      icon="mingcute:user-add-fill"
      class="inline"
    />
    <span class="ml-1">Add new</span>
  </submit-button>
</template>

<style scoped>
</style>
