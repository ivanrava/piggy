<script setup lang="ts">
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";
import axios from "axios";
import {ref} from "vue";
import BudgetFields from "./BudgetFields.vue";
import {useBudgetStore} from "../../../composables/useBudgetStore";

defineProps<{
  showForm: boolean,
}>();

const store = useBudgetStore();

const loading = ref(false);
const errors = ref({});
const emit = defineEmits(['update', 'close'])
const updateBudget = () => {
  loading.value = true;
  axios.put(`/categories/${store.stagingCategory.id}/budget`, store.buildCategoryPayload()).then(({data}) => {
    emit('close')
    emit('update', data.data)
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 left-8 md:left-auto bg-slate-50 dark:bg-stone-900 p-4 m-4 rounded-2xl drop-shadow-2xl ring-stone-200 dark:ring-stone-700 ring-1 dark:ring-2 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>
          Edit budget
        </h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="$emit('close')"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <form
        class="flex flex-col justify-center items-center gap-4 md:w-96 relative"
        @submit.prevent="updateBudget"
      >
        <BudgetFields
          v-model="store.stagingBudget"
          :errors="errors"
        />
        <submit-button>
          Confirm
        </submit-button>
      </form>
    </aside>
  </Transition>
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
