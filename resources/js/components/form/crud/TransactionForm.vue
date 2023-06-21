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

const store = useOperationsStore();

const props = defineProps<{
  accountId: number;
}>();

const form = ref({
  account_id: null,
  date: '',
  amount: 0,
  notes: '',
  beneficiary: {},
  category: {}
})

const maybeEditingId = store.isEditing ? '/'+store.getStagingOperation.id : '';
const transactionStoreUrl = ref(`/${store.isEditing && store.isEditingTransfer ? 'transfers' : 'transactions'}${maybeEditingId}`);
watchEffect(() => {
  transactionStoreUrl.value = `/${store.isEditing && store.isEditingTransfer ? 'transfers' : 'transactions'}${maybeEditingId}`;
})
const transactionTypes = computed(() => {
  const types = [
    {
      type: 'Transaction',
      id: `/transactions${maybeEditingId}`
    },
    {
      type: 'Transfer',
      id: `/transfers${maybeEditingId}`
    }
  ];
  if (store.isEditing) {
    return store.isEditingTransfer ? [types[1]] : [types[0]];
  } else {
    return types;
  }
})

const beneficiary_id = ref(null);
const category_id = ref(null);

const loading = ref(false);
const errors = ref({});
const storeTransaction = () => {
  loading.value = true;
  axios.post(transactionStoreUrl.value, actualPayload.value).then(({data}) => {
    store.closeForm();
    store.addOperation(data.data);
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}

const selectedAccountId = ref(null);
const actualPayload = computed(() => {
  // Computes between transaction & transfer
  return transactionStoreUrl.value === '/transactions' ? form.value : {
    from_account_id: isOut.value ? props.accountId : selectedAccountId.value,
    to_account_id: isOut.value ? selectedAccountId.value : props.accountId,
    notes: form.value.notes,
    amount: form.value.amount,
    date: form.value.date
  }
})

const isOut = ref(true);

const categories = ref([]);
const beneficiaries = ref([]);
const accounts = ref([]);
onMounted(() =>  {
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
});

const fakeId = -1;

const showBeneficiaryForm = ref(false);
const showCategoryForm = ref(false);
const addedBeneficiary = ref<Beneficiary|{}>({});
const addedCategory = ref<Category|{}>({});
const computedBeneficiaries = computed(() => beneficiaries.value.concat('id' in addedBeneficiary.value ? [addedBeneficiary.value] : []))
const computedCategories = computed(() => categories.value.concat('id' in addedCategory.value ? [addedCategory.value] : []))
const addBeneficiary = (b) => {
  addedBeneficiary.value = b;
  addedBeneficiary.value.id = fakeId;
  beneficiary_id.value = fakeId;
  // Show / hide shenanigans
  showBeneficiaryForm.value = false;
  store.showForm();
}
const addCategory = (c) => {
  addedCategory.value = c;
  addedCategory.value.id = fakeId;
  category_id.value = fakeId;
  // Show / hide shenanigans
  showCategoryForm.value = false;
  store.showForm();
}

watchEffect(() => form.value.account_id = props.accountId);
watchEffect(() => form.value.beneficiary = computedBeneficiaries.value.find(b => b.id === beneficiary_id.value))
watchEffect(() => form.value.category = computedCategories.value.find(c => c.id === category_id.value))
</script>

<template>
  <!-- Beneficiary modal form -->
  <beneficiary-form
    :show-form="showBeneficiaryForm"
    @store="addBeneficiary"
    @close="showBeneficiaryForm = false; store.showForm()"
  />
  <!-- Category modal form -->
  <category-form
    :show-form="showCategoryForm"
    @store="addCategory"
    @close="showCategoryForm = false; store.showForm()"
  />
  <!-- Main form transaction container -->
  <Transition name="slide-fade">
    <aside
      v-if="store.isFormShowed"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>{{ store.isEditing ? 'Edit' : 'New' }} operation</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="store.closeForm()"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <!-- Transaction type selector -->
      <tab-selector
        v-model="transactionStoreUrl"
        :tabs="transactionTypes"
      />
      <!-- Main form fields -->
      <form
        class="flex flex-col justify-center items-center gap-4 w-96"
        @submit.prevent="storeTransaction"
      >
        <!-- Variable fields -->
        <Transition
          name="fade-quick"
          mode="out-in"
        >
          <div
            v-if="transactionStoreUrl.startsWith('/transactions')"
            class="w-full flex flex-col justify-center items-center gap-4"
          >
            <select-input
              v-slot="{option}"
              v-model="beneficiary_id"
              :options="computedBeneficiaries"
              name="Beneficiary"
              :taggable="true"
              tag-placeholder="Add as a new beneficiary"
              :errors="errors.beneficiary"
              @tag="showBeneficiaryForm = true; store.closeForm()"
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
              v-model="category_id"
              :options="computedCategories"
              name="Category"
              :taggable="true"
              tag-placeholder="Add as a new category"
              :errors="errors.category"
              @tag="showCategoryForm = true; store.closeForm()"
            >
              <Icon
                :icon="option.icon"
                class="inline mr-1"
              />
              <span class="option__title text-sm">{{ option.name }}</span>
            </select-input>
          </div>
          <div
            v-else-if="transactionStoreUrl.startsWith('/transfers')"
            class="w-full flex flex-row gap-4 justify-center items-center"
          >
            <in-out-input v-model="isOut" />
            <select-input
              v-slot="{option}"
              v-model="selectedAccountId"
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
            v-model="form.date"
            type="date"
            label="Date"
            class="!w-full"
            :errors="errors.date"
          />
          <decimal-input
            v-model="form.amount"
            label="Amount"
            class="!w-full"
            :errors="errors.amount"
          />
        </div>
        <form-textarea
          v-model="form.notes"
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
    class="fixed right-12 bottom-12 flex items-center shadow-lg"
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
  transition: opacity 0.3s ease;
}

.fade-quick-enter-from,
.fade-quick-leave-to {
  opacity: 0;
}
</style>
