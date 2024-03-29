<script setup lang="ts">
import {Icon} from "@iconify/vue";
import IconInput from "../inputs/IconInput.vue";
import FormInput from "../inputs/FormInput.vue";
import SelectInput from "../inputs/SelectInput.vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {onMounted, ref, watch} from "vue";
import axios from "axios";
import TabSelector from "../inputs/TabSelector.vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";
import BudgetFields from "../../../pages/dashboard/budget/BudgetFields.vue";
import CheckboxInput from "../inputs/CheckboxInput.vue";

const props = defineProps<{
  showForm: Boolean,
  errors : {
    name: String,
    parent_category_id: String,
    icon: String
  },
  isLoading: boolean
}>();
defineEmits(['store', 'update', 'close'])

const store = useCategoriesStore();

const categoryTypes = [
  {
    id: 'out',
    type: 'Expense'
  },
  {
    id: 'in',
    type: 'Income'
  }
]
const fathers = ref([]);
const loadRootCategories = () => {
  axios.get("/categories/root").then(({data}) => {
    fathers.value = data.data;
  }).catch(({response}) => {
    console.log(response.data.errors)
  })
}
onMounted(loadRootCategories);
watch(props, (newValue) => {
  if (newValue.showForm)
    loadRootCategories();
}, {deep:true})
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 left-8 md:left-auto bg-slate-50 dark:bg-stone-900 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 dark:ring-stone-700 ring-1 dark:ring-2 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2 v-if="!store.isEditing">
          Add a new category
        </h2>
        <h2 v-else>
          Edit category
        </h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="$emit('close')"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <tab-selector
        v-if="store.stagingCategory.parent_category_id === null"
        v-model="store.stagingCategory.type"
        class="mb-4"
        :tabs="categoryTypes"
      />
      <form
        class="flex flex-col justify-center items-center gap-4 w-full md:w-96"
        @submit.prevent="$emit(store.isEditing ? 'update' : 'store', store.isEditing ? store.stagingCategory : store.buildCategoryPayload())"
      >
        <form-input
          v-model="store.stagingCategory.name"
          class="!w-full !mb-0"
          label="Category name"
          :errors="errors.name"
        />
        <select-input
          v-slot="{ option }"
          :model-value="store.stagingCategory.parent_category_id"
          :options="fathers"
          name="Parent category"
          :allow-empty="true"
          :errors="errors.parent_category_id"
          @update:model-value="store.stagingCategory.parent_category_id = $event; store.stagingCategory.parent = fathers.find(cat => cat.id === $event)"
        >
          <Icon
            :icon="option.icon"
            class="inline mr-1"
          />
          <span class="option__title">{{ option.name }}</span>
        </select-input>
        <icon-input
          v-model="store.stagingCategory.icon"
          :is-edit="store.isEditing"
          :errors="errors.icon"
        />
        <CheckboxInput
          v-if="store.stagingCategory.parent_category_id != null"
          v-model="store.stagingCategory.virtual"
          label="Hide this category from your reports"
          class="w-full pl-1"
          :errors="errors.virtual"
        />
        <div
          v-if="!store.isEditing && store.stagingCategory.parent_category_id != null"
          class="w-full flex flex-col gap-2"
        >
          <h3 class="text-left w-full px-1 my-0">
            Budget
          </h3>
          <BudgetFields
            v-model="store.stagingCategory.budgetFields"
            :errors="errors"
          />
        </div>
        <submit-button
          class="block w-full"
          :is-loading="isLoading"
        >
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
