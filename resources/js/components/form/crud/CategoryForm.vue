<script setup lang="ts">
import FormInput from "../inputs/FormInput.vue";
import {onMounted, ref} from "vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import IconInput from "../inputs/IconInput.vue";
import SelectInput from "../inputs/SelectInput.vue";

const showForm = ref(false);

interface StoreCategoryPayload {
  name: string;
  type: string;
  icon: string;
  parent_category_id: number;
}

const form = ref({
  name: '',
  type: 'out',
  icon: '',
  parent_category_id: null
})

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

const categoryTypes = [
  {
    id: 'out',
    display: 'Expense'
  },
  {
    id: 'in',
    display: 'Income'
  }
]

const fathers = ref([]);
onMounted(() =>  {
  axios.get("/categories").then(({data}) => {
    fathers.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>Add a new category</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="showForm = false"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <div class="button-group">
        <button
          v-for="t in categoryTypes"
          :key="t.id"
          class="m-2 pb-1 border-pink-100/20 text-pink-700/70 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700"
          :class="{'!border-pink-700 !text-pink-950 !font-normal': t.id === form.type}"
          @click="form.type = t.id"
        >
          {{ t.display }}
        </button>
      </div>
      <form
        class="flex flex-col justify-center items-center gap-4 w-96"
        @submit.prevent="storeCategory(form)"
      >
        <form-input
          v-model="form.name"
          class="!w-full"
          label="Category name"
        />
        <select-input
          :options="fathers"
          name="Parent category"
          v-model="form.parent_category_id"
          v-slot="{ option }"
        >
          <Icon :icon="option.icon" class="inline mr-1" />
          <span class="option__title">{{ option.name }}</span>
        </select-input>
        <icon-input v-model="form.icon" />
        <submit-button>
          Confirm
        </submit-button>
      </form>
    </aside>
  </Transition>
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
.slide-fade-enter-active {
  transition: all 0.6s cubic-bezier(.62,.16,.13,1.01);
}

.slide-fade-leave-active {
  transition: all 0.6s cubic-bezier(.62,.16,.13,1.01);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(120%);
}
</style>
