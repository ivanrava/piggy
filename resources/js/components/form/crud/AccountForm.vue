<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>Add a new account</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="showForm = false"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <tab-selector
        v-model="form.account_type_id"
        :tabs="accountTypes"
      />
      <form
        class="flex flex-col justify-center items-center gap-4 w-96 relative"
        @submit.prevent="storeCategory(form)"
      >
        <div class="w-full flex flex-row justify-between">
          <form-input
            v-model="form.name"
            class="!w-full"
            label="Account name"
            :errors="errors.name"
          />
          <color-picker
            v-model="form.color"
            class="!ml-3"
          />
        </div>
        <div class="w-full flex flex-row gap-2 justify-between">
          <form-input
            v-model="form.opening"
            :errors="errors.opening"
            type="date"
            label="Opening date"
            class="!w-full"
          />
          <form-input
            v-model="form.closing"
            :errors="errors.closing"
            type="date"
            label="Closing date"
            class="!w-full"
          />
          <decimal-input
            v-model="form.initial_balance"
            :errors="errors.initial_balance"
            label="Balance"
          />
        </div>
        <icon-input
          v-model="form.icon"
          :errors="errors.icon"
        />
        <form-textarea
          v-model="form.description"
          :errors="errors.description"
          label="Description"
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
      icon="material-symbols:add-card-rounded"
      class="inline"
    />
    <span class="ml-1">Add new</span>
  </submit-button>
</template>

<script setup lang="ts">
import FormInput from "../inputs/FormInput.vue";
import {onMounted, ref} from "vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import IconInput from "../inputs/IconInput.vue";
import FormTextarea from "../inputs/FormTextarea.vue";
import ColorPicker from "../inputs/ColorPicker.vue";
import DecimalInput from "../inputs/DecimalInput.vue";
import TabSelector from "../inputs/TabSelector.vue";

const showForm = ref(false);

interface StoreAccountPayload {
  name: string;
  account_type_id: number;
  initial_balance: string;
  icon: string;
  color: string;
  opening: string;
  closing?: string;
  description: string;
}

const form = ref({
  name: '',
  account_type_id: 1,
  initial_balance: 0,
  icon: '',
  color: '#ccc',
  opening: '',
  closing: '',
  description: ''
})

const emit = defineEmits(['store'])

const loading = ref(false);
const errors = ref({});
const storeCategory = function (payload: StoreAccountPayload) {
  loading.value = true;
  axios.post("/accounts", payload).then(({data}) => {
    showForm.value = false;
    emit('store', data.data)
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}

const accountTypes = ref([]);
onMounted(() => {
  axios.get("/account_types").then(({data}) => {
    accountTypes.value = data;
  })
})
</script>

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
