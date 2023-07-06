<script setup lang="ts">
import FormInput from "../inputs/FormInput.vue";
import {onMounted, ref, watchEffect, computed} from "vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import SelectInput from "../inputs/SelectInput.vue";
import FormTextarea from "../inputs/FormTextarea.vue";
import BeneficiaryImage from "../../BeneficiaryImage.vue";
import DecimalInput from "../inputs/DecimalInput.vue";
import BeneficiaryForm from "./BeneficiaryForm.vue";
import InOutInput from "../inputs/InOutInput.vue";
import CategoryForm from "./CategoryForm.vue";
import {Beneficiary, Category} from "../../../composables/interfaces";
import {useOperationsStore} from "../../../composables/useOperationsStore";
import TabSelector from "../inputs/TabSelector.vue";
import {useCategoriesStore} from "../../../composables/useCategoriesStore";

const store = useOperationsStore();
const storeCategories = useCategoriesStore();

const props = defineProps<{
  accountId: number;
}>();

const categories = ref([]);
const beneficiaries = ref([]);
const accounts = ref([]);
const fetchOptions = () => {
  // Fetch categories
  axios.get("/categories/leaves").then(({data}) => {
    categories.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch beneficiaries
  axios.get("/beneficiaries").then(({data}) => {
    beneficiaries.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch accounts
  axios.get("/accounts").then(({data}) => {
    accounts.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })

  // Resets added beneficiary / category
  addedBeneficiary.value = {id:null}
  addedCategory.value = {id:null}
}
onMounted(fetchOptions);

const operationTypes = computed(() => {
  const urlSuffixForUpdate = store.isEditing ? '/'+store.getStagingOperation.id : ''
  return [
    {
      type: 'Transaction',
      id: `/transactions${urlSuffixForUpdate}`
    },
    {
      type: 'Transfer',
      id: `/transfers${urlSuffixForUpdate}`
    }
  ]
});
const operationURL = computed(() => operationTypes.value[store.isEditingTransfer ? 1 : 0].id)

const loading = ref(false);
const errors = ref({});
const storeOperation = () => {
  loading.value = true;
  axios.post(operationURL.value, actualPayload.value).then(({data}) => {
    store.closeForm(false);
    store.addOperation(data.data);
    errors.value = [];
    fetchOptions();
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
const updateOperation = () => {
  loading.value = true;
  axios.put(operationURL.value, actualPayload.value).then(({data}) => {
    store.closeForm(false);
    store.updateOperation(data.data);
    errors.value = [];
    fetchOptions();
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}

const actualPayload = computed(() => {
  // Computes between transaction & transfer
  return !store.isEditingTransfer ? store.stagingTransaction : {
    from_account_id: store.stagingTransfer.isOut ? props.accountId : store.stagingTransfer.account_id,
    to_account_id: store.stagingTransfer.isOut ? store.stagingTransfer.account_id : props.accountId,
    notes: store.stagingTransfer.notes,
    amount: store.stagingTransfer.amount,
    date: store.stagingTransfer.date
  }
})

const fakeId = -1;

const showBeneficiaryForm = ref(false);
const showCategoryForm = ref(false);
const addedBeneficiary = ref<Beneficiary|{id:Number}>({id:null});
const addedCategory = ref<Category|{id:Number}>({id:null});
const computedBeneficiaries = computed(() => beneficiaries.value.concat(addedBeneficiary.value.id === fakeId ? [addedBeneficiary.value] : []))
const computedCategories = computed(() => categories.value.concat(addedCategory.value.id === fakeId ? [addedCategory.value] : []))
const addBeneficiary = (b: Beneficiary) => {
  addedBeneficiary.value = b;
  addedBeneficiary.value.id = fakeId;
  store.stagingTransaction.beneficiary.id = fakeId;
  store.stagingTransaction.beneficiary.name = b.name;
  store.stagingTransaction.beneficiary.img = b.img;
  // Show / hide shenanigans
  showBeneficiaryForm.value = false;
  store.showForm();
}
const addCategory = (c: Category) => {
  addedCategory.value = c;
  addedCategory.value.id = fakeId;
  store.stagingTransaction.category.id = fakeId;
  store.stagingTransaction.category.name = c.name;
  store.stagingTransaction.category.parent_category_id = c.parent_category_id;
  store.stagingTransaction.category.icon = c.icon;
  // Show / hide shenanigans
  showCategoryForm.value = false;
  store.showForm();
}

// Updates the transaction account id when the page changes
watchEffect(() => store.stagingTransaction.account_id = props.accountId);
</script>

<template>
  <!-- Beneficiary modal form -->
  <beneficiary-form
    :show-form="showBeneficiaryForm"
    :errors="{name:''}"
    @store="addBeneficiary"
    @close="showBeneficiaryForm = false; store.showForm()"
  />
  <!-- Category modal form -->
  <category-form
    :show-form="showCategoryForm"
    :errors="{name:''}"
    @store="addCategory"
    @close="showCategoryForm = false; store.showForm()"
  />
  <!-- Main form transaction container -->
  <Transition name="slide-fade">
    <aside
      v-if="store.isShowForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>{{ store.isEditing ? 'Edit' : 'New' }} operation</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="store.closeForm(false)"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <!-- Transaction type selector -->
      <tab-selector
        v-if="!store.isEditing"
        :model-value="store.isEditingTransfer ? operationTypes[1].id : operationTypes[0].id"
        :tabs="operationTypes"
        @update:model-value="store.changeOperationType($event.startsWith('/transfers'))"
      />
      <!-- Main form fields -->
      <form
        class="flex flex-col justify-center items-center gap-4 w-96"
        @submit.prevent="store.isEditing ? updateOperation() : storeOperation()"
      >
        <!-- Variable fields -->
        <Transition
          name="fade-quick"
          mode="out-in"
        >
          <div
            v-if="!store.isEditingTransfer"
            class="w-full flex flex-col justify-center items-center gap-4"
          >
            <select-input
              v-slot="{option}"
              v-model="store.stagingTransaction.beneficiary.id"
              :options="computedBeneficiaries"
              name="Beneficiary"
              :taggable="true"
              tag-placeholder="Add as a new beneficiary"
              :errors="errors.beneficiary"
              @tag="showBeneficiaryForm = true; store.closeForm(store.isEditing)"
            >
              <article class="flex items-center">
                <beneficiary-image
                  :beneficiary="option"
                  class="!p-0 mr-2 !w-4 !h-4 !rounded-sm"
                />
                <span class="option__title text-sm">{{ option.name }}</span>
              </article>
            </select-input>
            <select-input
              v-slot="{option}"
              v-model="store.stagingTransaction.category.id"
              :options="computedCategories"
              name="Category"
              :taggable="true"
              tag-placeholder="Add as a new category"
              :errors="errors.category"
              @tag="showCategoryForm = true; store.closeForm(store.isEditing); storeCategories.isEditing = false"
            >
              <Icon
                :icon="option.icon"
                class="inline mr-1"
              />
              <span class="option__title text-sm">{{ option.name }}</span>
            </select-input>
          </div>
          <div
            v-else-if="store.isEditingTransfer"
            class="w-full flex flex-row gap-4 justify-center items-center"
          >
            <in-out-input v-model="store.stagingTransfer.isOut" />
            <select-input
              v-slot="{option}"
              v-model="store.stagingTransfer.account_id"
              :options="accounts.filter((acc) => acc.id != accountId)"
              name="Other account"
              :errors="'to_account_id' in errors ? errors.to_account_id : errors.from_account_id"
            >
              <Icon
                :icon="option.icon"
                class="inline mr-1"
              />
              <span
                class="option__title text-sm"
              >
                {{ option.name }}
              </span>
            </select-input>
          </div>
        </Transition>
        <!-- Fixed fields -->
        <div class="w-full flex justify-between gap-4">
          <form-input
            v-model="store.getStagingOperation.date"
            type="date"
            label="Date"
            class="!w-full"
            :errors="errors.date"
          />
          <decimal-input
            v-model="store.getStagingOperation.amount"
            label="Amount"
            class="!w-full"
            :errors="errors.amount"
          />
        </div>
        <form-textarea
          v-model="store.getStagingOperation.notes"
          label="Notes"
          class="!w-full"
          :errors="errors.notes"
        />
        <submit-button class="block w-full">
          Confirm
        </submit-button>
      </form>
    </aside>
  </Transition>
  <!-- Show form button -->
  <submit-button
    class="md:fixed right-12 bottom-12 md:flex items-center shadow-lg !mt-4"
    @click="store.showForm()"
  >
    <Icon
      icon="material-symbols:currency-exchange"
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

.fade-quick-enter-active,
.fade-quick-leave-active {
  transition: opacity 0.2s ease;
}

.fade-quick-enter-from,
.fade-quick-leave-to {
  opacity: 0;
}
</style>
