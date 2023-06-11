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
import CategoryForm from "./CategoryForm.vue";

const showForm = ref(false);

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

const emit = defineEmits(['added']);

const loading = ref(false);
const errors = ref({});
const storeTransaction = () => {
  loading.value = true;
  axios.post(transactionStoreUrl.value, actualPayload.value).then(({data}) => {
    showForm.value = false;
    emit('added', data.data);
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

const transactionStoreUrl = ref('/transactions');
const transactionTypes = [
  {
    name: 'Transaction',
    url: '/transactions'
  },
  {
    name: 'Transfer',
    url: '/transfers'
  }
]

const isOut = ref(true);

const categories = ref([]);
const beneficiaries = ref([]);
const accounts = ref([]);
onMounted(() =>  {
  // Fetch categories
  axios.get("/categories").then(({data}) => {
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
const beneficiary_id = ref(null);
const category_id = ref(null);

const showBeneficiaryForm = ref(false);
const showCategoryForm = ref(false);
const addedBeneficiary = ref({});
const addedCategory = ref({});
const computedBeneficiaries = computed(() => beneficiaries.value.concat('id' in addedBeneficiary.value ? [addedBeneficiary.value] : []))
const computedCategories = computed(() => categories.value.concat('id' in addedCategory.value ? [addedCategory.value] : []))
const addBeneficiary = (b) => {
  addedBeneficiary.value = b;
  addedBeneficiary.value.id = fakeId;
  beneficiary_id.value = fakeId;
  // Show / hide shenanigans
  showBeneficiaryForm.value = false;
  showForm.value = true;
}
const addCategory = (c) => {
  addedCategory.value = c;
  addedCategory.value.id = fakeId;
  category_id.value = fakeId;
  // Show / hide shenanigans
  showCategoryForm.value = false;
  showForm.value = true;
}

watchEffect(() => form.value.account_id = props.accountId);
watchEffect(() => form.value.beneficiary = computedBeneficiaries.value.find(b => b.id === beneficiary_id.value))
watchEffect(() => form.value.category = computedCategories.value.find(c => c.id === category_id.value))
</script>

<template>
  <beneficiary-form
    :show-form="showBeneficiaryForm"
    @store="addBeneficiary"
    @close="showBeneficiaryForm = false; showForm = true"
  />
  <category-form
    :show-form="showCategoryForm"
    @store="addCategory"
    @close="showCategoryForm = false; showForm = true"
  />
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>New operation</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="showForm = false"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <div class="button-group">
        <button
          v-for="t in transactionTypes"
          :key="t.url"
          class="m-2 pb-1 border-pink-100/20 text-pink-700/70 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700"
          :class="{'!border-pink-700 !text-pink-950 !font-normal': transactionStoreUrl === t.url}"
          @click="transactionStoreUrl = t.url"
        >
          {{ t.name }}
        </button>
      </div>
      <form
        class="flex flex-col justify-center items-center gap-4 w-96"
        @submit.prevent="storeTransaction"
      >
        <Transition
          name="fade-quick"
          mode="out-in"
        >
          <div
            v-if="transactionStoreUrl === '/transactions'"
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
              @tag="showBeneficiaryForm = true; showForm = false"
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
              @tag="showCategoryForm = true; showForm = false"
            >
              <Icon
                :icon="option.icon"
                class="inline mr-1"
              />
              <span class="option__title text-sm">{{ option.name }}</span>
            </select-input>
          </div>
          <div
            v-else-if="transactionStoreUrl === '/transfers'"
            class="w-full flex flex-row gap-4 justify-center items-center"
          >
            <label
              class="inline-flex items-center cursor-pointer mt-6"
              @click="isOut = !isOut"
            >
              <span class="mx-2 text-sm font-serif text-gray-500">To</span>
              <div
                class="w-12 h-6 rounded-full relative transition-all duration-300"
                :class="isOut ? 'bg-red-800/50' : 'bg-green-800/50'"
              >
                <div
                  class="absolute h-6 w-6 bg-white rounded-full border-[1px] transition-all"
                  :class="isOut ? 'left-0 border-red-900/30' : 'left-1/2 border-green-900/30'"
                />
              </div>
              <span class="mx-2 text-sm font-serif text-gray-500">From</span>
            </label>
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
  <submit-button
    class="fixed right-12 bottom-12 flex items-center shadow-lg"
    @click="showForm = true"
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
