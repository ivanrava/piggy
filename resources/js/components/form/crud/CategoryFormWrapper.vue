<script setup lang="ts">
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import CategoryForm from "./CategoryForm.vue";
import {ref} from "vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";


interface StoreCategoryPayload {
  name: string;
  type: string;
  icon: string;
  parent_category_id: number;
}

const store = useCategoriesStore();

const loading = ref(false);
const errors = ref({});
const storeCategory = function (payload: StoreCategoryPayload) {
  loading.value = true;
  axios.post("/categories", payload).then(({data}) => {
    store.showForm = false;
    store.selectCategory(data.data)
    store.refreshCategories();
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
const updateCategory = function (payload: StoreCategoryPayload) {
  loading.value = true;
  axios.put(`/categories/${store.selectedCategory.id}`, payload).then(({data}) => {
    store.showForm = false;
    store.isEditing = false;
    store.selectCategory(data.data)
    store.refreshCategories();
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
    :show-form="store.showForm"
    :errors="errors"
    @store="(form) => storeCategory(form)"
    @update="(form) => updateCategory(form)"
    @close="store.showForm = false; store.isEditing = false"
  />
  <submit-button
    class="fixed right-12 bottom-12 flex items-center shadow-lg print:hidden"
    @click="store.showForm = true"
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
