<script setup lang="ts">
import FormInput from "./FormInput.vue";
import {ref, computed} from "vue";
import BeneficiaryImage from "../BeneficiaryImage.vue";
import SubmitButton from "./SubmitButton.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";

const name = ref('');
const showForm = ref(false);
const domain = ref('');
const beneficiaryType = ref('person');
const beneficiaryTypes = [
  {
    id: 'person',
    display: 'People'
  },
  {
    id: 'company',
    display: 'Companies'
  },
  {
    id: 'generic',
    display: 'Generic'
  }
]
const imgForType = function(type) {
  const defaultStyles = {
    person: 'bottts',
    generic: 'shapes'
  }
  if (type === 'company')
    return 'https://logo.clearbit.com/'+domain.value
  else
    return defaultStyles[type]
}

interface StoreBeneficiaryPayload {
  name: string;
  img: string;
}

const form = computed(() => {
  return {
    name: name.value,
    img: imgForType(beneficiaryType.value)
  }
})

const loading = ref(false);
const errors = ref({});
const storeBeneficiary = function (payload: StoreBeneficiaryPayload) {
  loading.value = true;
  axios.post("/beneficiaries", payload).then(() => {
    showForm.value = false;
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
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
      v-if="showForm"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>Add a new beneficiary</h2>
        <a class="flex flex-row items-center cursor-pointer" @click="showForm = false">
          <span class="mr-1">Close</span>
        </a>
      </header>
      <div class="button-group">
        <button
          v-for="t in beneficiaryTypes"
          class="m-2 pb-1 border-pink-100/20 text-pink-700/70 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700"
          :class="{'!border-pink-700 !text-pink-950 !font-normal': t.id === beneficiaryType}"
          @click="beneficiaryType = t.id"
        >
          {{ t.display }}
        </button>
      </div>
      <form
        class="flex flex-wrap justify-start items-center h-24 gap-4"
        @submit.prevent="storeBeneficiary(form)"
      >
        <beneficiary-image
          class="!w-20 !h-20"
          :beneficiary="form"
        />
        <aside class="flex flex-row justify-center">
          <Transition name="fade" mode="out-in">
            <div v-if="beneficiaryType === 'company'" class="flex flex-row justify-around w-80">
              <form-input class="mr-4 !w-40" placeholder="Google" name="Company name" v-model="name" />
              <form-input class="mr-4 !w-36" placeholder="google.com" name="Company domain" v-model="domain" v-if="beneficiaryType === 'company'" />
            </div>
            <div class="w-80" v-else-if="beneficiaryType === 'person'">
              <form-input class="mr-4 !w-72" placeholder="John Smith" name="Beneficiary name" v-model="name" />
            </div>
            <div class="w-80" v-else>
              <form-input class="mr-4 !w-72" placeholder="Food" name="Generic beneficiary name" v-model="name" />
            </div>
          </Transition>
          <submit-button>
            Confirm
          </submit-button>
        </aside>
      </form>
    </aside>
  </Transition>
  <submit-button class="fixed right-12 bottom-12 flex items-center shadow-lg" @click="showForm = true">
    <Icon icon="mingcute:user-add-fill" class="inline"/>
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
