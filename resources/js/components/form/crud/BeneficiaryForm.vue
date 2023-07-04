<script setup lang="ts">
import BeneficiaryImage from "../../BeneficiaryImage.vue";
import FormInput from "../inputs/FormInput.vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {computed, ref} from "vue";
import {useBeneficiariesStore} from "../../../composables/useBeneficiariesStore";

const store = useBeneficiariesStore();

defineProps<{
  showForm: Boolean,
  errors: {
    name: String
  }
}>()
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

const imgForType = computed(() => {
  const defaultStyles = {
    person: 'bottts',
    generic: 'shapes'
  }
  if (beneficiaryType.value === 'company')
    return 'https://logo.clearbit.com/'+domain.value
  else
    return defaultStyles[beneficiaryType.value]
})

defineEmits(['store', 'close', 'update'])
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>Add a new beneficiary</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="$emit('close')"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <div class="button-group">
        <button
          v-for="t in beneficiaryTypes"
          :key="t.id"
          class="m-2 pb-1 border-pink-100/20 text-pink-700/70 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700"
          :class="{'!border-pink-700 !text-pink-950 !font-normal': t.id === beneficiaryType}"
          @click="beneficiaryType = t.id; store.stagingBeneficiary.img = imgForType"
        >
          {{ t.display }}
        </button>
      </div>
      <form
        class="flex flex-wrap justify-start items-center h-24 gap-4"
        @submit.prevent="store.isEditing ? $emit('update', store.stagingBeneficiary) : $emit('store', store.stagingBeneficiary)"
      >
        <beneficiary-image
          class="!w-20 !h-20"
          :beneficiary="store.stagingBeneficiary"
        />
        <aside class="flex flex-row justify-center">
          <Transition
            name="fade"
            mode="out-in"
          >
            <div
              v-if="beneficiaryType === 'company'"
              class="flex flex-row justify-around w-80"
            >
              <form-input
                v-model="store.stagingBeneficiary.name"
                class="mr-4 !w-40"
                label="Company name"
                :errors="errors.name"
              />
              <form-input
                :model-value="domain"
                class="mr-4 !w-36"
                label="Company domain"
                @update:model-value="domain = $event; store.stagingBeneficiary.img = imgForType"
              />
            </div>
            <div
              v-else-if="beneficiaryType === 'person'"
              class="w-80"
            >
              <form-input
                v-model="store.stagingBeneficiary.name"
                class="mr-4 !w-72"
                label="Beneficiary name"
                :errors="errors.name"
              />
            </div>
            <div
              v-else
              class="w-80"
            >
              <form-input
                v-model="store.stagingBeneficiary.name"
                class="mr-4 !w-72"
                label="Generic beneficiary name"
                :errors="errors.name"
              />
            </div>
          </Transition>
          <submit-button>
            Confirm
          </submit-button>
        </aside>
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
