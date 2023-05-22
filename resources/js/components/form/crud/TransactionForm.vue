<script setup lang="ts">
import FormInput from "../inputs/FormInput.vue";
import {onMounted, ref, watchEffect} from "vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import SelectInput from "../inputs/SelectInput.vue";
import FormTextarea from "../inputs/FormTextarea.vue";
import BeneficiaryImage from "../../BeneficiaryImage.vue";
import DecimalInput from "../inputs/DecimalInput.vue";

const showForm = ref(false);

const props = defineProps<{
  accountId: number;
}>();

interface StoreTransactionPayload {
  account_id: number;
  category_id: number;
  beneficiary_id: number;
  date: string;
  amount: number;
  notes: string;
}

const form = ref({
  account_id: null,
  category_id: null,
  beneficiary_id: null,
  date: '',
  amount: 0,
  notes: ''
})

const emit = defineEmits(['added']);

const loading = ref(false);
const errors = ref({});
const storeTransaction = function (payload: StoreTransactionPayload) {
  loading.value = true;
  axios.post("/transactions", payload).then(({data}) => {
    showForm.value = false;
    emit('added', data.data);
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}

const categories = ref([]);
const beneficiaries = ref([]);
onMounted(() =>  {
  // Fetch categories
  axios.get("/categories").then(({data}) => {
    categories.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch categories
  axios.get("/beneficiaries").then(({data}) => {
    beneficiaries.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});

watchEffect(() => form.value.account_id = props.accountId);
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>New transaction</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="showForm = false"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <form
        class="flex flex-col justify-center items-center gap-4 w-96"
        @submit.prevent="storeTransaction(form)"
      >
        <select-input
          v-slot="{option}"
          v-model="form.beneficiary_id"
          :options="beneficiaries"
          name="Beneficiary"
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
          v-model="form.category_id"
          :options="categories"
          name="Category"
        >
          <Icon
            :icon="option.icon"
            class="inline mr-1"
          />
          <span class="option__title text-sm">{{ option.name }}</span>
        </select-input>
        <div class="w-full flex justify-between gap-4">
          <form-input
            v-model="form.date"
            type="date"
            label="Date"
            class="!w-full"
          />
          <decimal-input
            v-model="form.amount"
            label="Amount"
            class="!w-full"
          />
        </div>
        <form-textarea
          v-model="form.notes"
          label="Notes"
          class="!w-full"
        />
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
</style>