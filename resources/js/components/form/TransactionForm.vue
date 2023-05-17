<script setup lang="ts">
import FormInput from "./FormInput.vue";
import {onMounted, ref} from "vue";
import SubmitButton from "./SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import SelectInput from "./SelectInput.vue";
import FormTextarea from "./FormTextarea.vue";
import BeneficiaryImage from "../BeneficiaryImage.vue";
import DecimalInput from "./DecimalInput.vue";

const showForm = ref(false);

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

const loading = ref(false);
const errors = ref({});
const storeTransaction = function (payload: StoreTransactionPayload) {
  loading.value = true;
  axios.post("/transactions", payload).then(() => {
    showForm.value = false;
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}

const categories = ref([]);
onMounted(() =>  {
  axios.get("/categories").then(({data}) => {
    categories.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
const beneficiaries = ref([]);
onMounted(() =>  {
  axios.get("/beneficiaries").then(({data}) => {
    beneficiaries.value = data.data;
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
          :options="beneficiaries"
          name="Beneficiary"
          v-model="form.beneficiary_id"
          v-slot="{option}"
        >
          <article class="flex items-center">
            <beneficiary-image :beneficiary="option" class="!w-12 !h-12" />
            <span class="option__title">{{ option.name }}</span>
          </article>
        </select-input>
        <select-input
          :options="categories"
          name="Category"
          v-model="form.category_id"
          v-slot="{option}"
        >
          <Icon :icon="option.icon" class="inline mr-1" />
          <span class="option__title">{{ option.name }}</span>
        </select-input>
        <div class="w-full flex justify-between">
          <form-input
            v-model="form.date"
            type="date"
            name="Date"
            class="!w-full"
          />
          <decimal-input
            v-model="form.amount"
            name="Amount"
            class="!w-full"
          />
        </div>
        <form-textarea
          v-model="form.notes"
          name="Notes"
          class="!w-full"
          placeholder="Details, notes or whatever you like"
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
