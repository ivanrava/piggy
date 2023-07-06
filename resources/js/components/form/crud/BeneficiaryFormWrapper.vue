<script setup lang="ts">
import {ref} from "vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import BeneficiaryForm from "./BeneficiaryForm.vue";
import {useBeneficiariesStore} from "../../../composables/useBeneficiariesStore";

const showForm = ref(false);

interface StoreBeneficiaryPayload {
  name: string;
  img: string;
}

const store = useBeneficiariesStore();

const emit = defineEmits(['store', 'update'])

const loading = ref(false);
const errors = ref({});
const storeBeneficiary = function (payload: StoreBeneficiaryPayload) {
  loading.value = true;
  axios.post("/beneficiaries", payload).then(({data}) => {
    emit('store', data.data)
    store.closeForm();
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
const updateBeneficiary = function (payload: StoreBeneficiaryPayload) {
  loading.value = true;
  axios.put(`/beneficiaries/${store.stagingBeneficiary.id}`, payload).then(({data}) => {
    emit('update', data.data)
    store.updateBeneficiary(data.data);
    store.closeForm();
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
    :show-form="store.showForm"
    :errors="errors"
    @store="(form) => storeBeneficiary(form)"
    @update="(form) => updateBeneficiary(form)"
    @close="store.closeForm()"
  />
  <submit-button
    class="md:fixed right-12 bottom-12 md:flex items-center shadow-lg !mt-4"
    @click="store.showForm = true"
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
