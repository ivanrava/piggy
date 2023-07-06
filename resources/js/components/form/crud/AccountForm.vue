<template>
  <Transition name="slide-fade">
    <aside
      v-if="store.showForm"
      class="fixed bottom-0 md:bottom-8 right-0 md:right-8 bg-slate-50 p-4 m-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2 v-if="!store.isEditing">
          Add a new account
        </h2>
        <h2 v-else>
          Edit account
        </h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="store.showForm = false; store.isEditing = false;"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <tab-selector
        v-model="store.stagingAccount.account_type_id"
        :tabs="accountTypes"
      />
      <form
        class="flex flex-col justify-center items-center gap-4 md:w-96 relative"
        @submit.prevent="store.isEditing ? updateAccount(store.stagingAccount) : storeAccount(store.stagingAccount)"
      >
        <div class="w-full flex flex-row justify-between items-start">
          <form-input
            v-model="store.stagingAccount.name"
            class="!w-full"
            label="Account name"
            :errors="errors.name"
          />
          <color-picker
            v-model="store.stagingAccount.color"
            class="!ml-3 mt-2.5"
          />
        </div>
        <div class="w-full flex flex-col md:flex-row gap-2 justify-between">
          <form-input
            v-model="store.stagingAccount.opening"
            :errors="errors.opening"
            type="date"
            label="Opening date"
            class="!w-full"
          />
          <form-input
            v-model="store.stagingAccount.closing"
            :errors="errors.closing"
            type="date"
            label="Closing date"
            class="!w-full"
          />
          <decimal-input
            v-model="store.stagingAccount.initial_balance"
            :errors="errors.initial_balance"
            label="Balance"
          />
        </div>
        <icon-input
          v-model="store.stagingAccount.icon"
          :errors="errors.icon"
        />
        <form-textarea
          v-model="store.stagingAccount.description"
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
    class="md:fixed right-12 bottom-12 md:flex items-center shadow-lg !mt-4"
    @click="store.showForm = true; store.isEditing = false; store.emptyForm();"
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
import {useAccountsStore} from "../../../composables/useAccountsStore";

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

const emit = defineEmits(['store', 'update'])

const store = useAccountsStore();

const loading = ref(false);
const errors = ref({});
const storeAccount = function (payload: StoreAccountPayload) {
  loading.value = true;
  axios.post("/accounts", payload).then(({data}) => {
    store.showForm = false;
    emit('store', data.data)
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
const updateAccount = function (payload: StoreAccountPayload) {
  loading.value = true;
  axios.put(`/accounts/${store.stagingAccount.id}`, payload).then(({data}) => {
    store.showForm = false;
    emit('update', data.data)
    errors.value = [];
    console.log(data.data)
  }).catch(({response}) => {
    console.log("Ciao")
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
