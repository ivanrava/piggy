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
  },
  isLoading: boolean
}>()
const domain = ref('');

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
  if (store.beneficiaryType === 'company')
    return 'https://logo.clearbit.com/'+domain.value
  else
    return defaultStyles[store.beneficiaryType]
})

defineEmits(['store', 'close', 'update'])
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 left-8 md:left-auto bg-slate-50 dark:bg-stone-900 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 dark:ring-stone-700 ring-1 dark:ring-2 z-10 md:w-96"
    >
      <header class="flex flex-row justify-between items-center">
        <h2 v-if="store.isEditing">
          Edit beneficiary
        </h2>
        <h2 v-else>
          Add a new beneficiary
        </h2>
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
          class="m-2 pb-1 border-pink-100/20 text-pink-700/70 dark:text-pink-100/40 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700 dark:hover:border-pink-700/60 dark:hover:text-pink-700"
          :class="{'!border-pink-700 dark:!border-pink-400 !text-pink-950 dark:!text-pink-400 !font-normal': t.id === store.beneficiaryType}"
          @click="store.beneficiaryType = t.id; store.stagingBeneficiary.img = imgForType"
        >
          {{ t.display }}
        </button>
      </div>
      <form
        class="flex flex-col justify-start items-center gap-2 md:gap-4"
        @submit.prevent="store.isEditing ? $emit('update', store.stagingBeneficiary) : $emit('store', store.stagingBeneficiary)"
      >
        <beneficiary-image
          class="!w-20 !h-20"
          :beneficiary="store.stagingBeneficiary"
        />
        <aside class="flex flex-col justify-center w-full">
          <Transition
            name="fade"
            mode="out-in"
          >
            <div
              v-if="store.beneficiaryType === 'company'"
              class="flex flex-row justify-between w-full gap-4"
            >
              <form-input
                v-model="store.stagingBeneficiary.name"
                class="!w-full"
                label="Company name"
                :errors="errors.name"
              />
              <form-input
                :model-value="domain"
                class="!w-full"
                label="Company domain"
                @update:model-value="domain = $event; store.stagingBeneficiary.img = imgForType"
              />
            </div>
            <div
              v-else-if="store.beneficiaryType === 'person'"
              class="w-full"
            >
              <form-input
                v-model="store.stagingBeneficiary.name"
                class="mr-4 !w-full"
                label="Beneficiary name"
                :errors="errors.name"
              />
            </div>
            <div
              v-else
              class="w-full"
            >
              <form-input
                v-model="store.stagingBeneficiary.name"
                class="mr-4 !w-full"
                label="Generic beneficiary name"
                :errors="errors.name"
              />
            </div>
          </Transition>
          <submit-button
            class=""
            :is-loading="isLoading"
          >
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
