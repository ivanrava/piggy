<script setup lang="ts">
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import CategoryForm from "./CategoryForm.vue";
import {ref} from "vue";

const showForm = ref(false);

interface StoreCategoryPayload {
  name: string;
  type: string;
  icon: string;
  parent_category_id: number;
}


const loading = ref(false);
const errors = ref({});
const storeCategory = function (payload: StoreCategoryPayload) {
  loading.value = true;
  axios.post("/categories", payload).then(() => {
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
  <category-form
    :show-form="showForm"
    @store="(form) => storeCategory(form)"
    @close="showForm = false"
  />
  <submit-button
    class="fixed right-12 bottom-12 flex items-center shadow-lg"
    @click="showForm = true"
  >
    <Icon
      icon="material-symbols:format-list-bulleted-add-rounded"
      class="inline"
    />
    <span class="ml-1">Add new</span>
  </submit-button>
</template>

<style scoped>
</style>
