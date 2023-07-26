<script setup lang="ts">
import FormInput from "../inputs/FormInput.vue";
import {ref} from "vue";
import DecimalInput from "../inputs/DecimalInput.vue";
import FormTextarea from "../inputs/FormTextarea.vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {Property} from "../../../composables/interfaces";
import axios from "axios";
import {usePropertyStore} from "../../../composables/usePropertiesStore";

const props = defineProps<{
  showForm: boolean,
  isOut: boolean,
  property: Property
}>()

const store = usePropertyStore();

const emit = defineEmits(['close']);

const form = ref({
  date: '',
  amount: 0,
  notes: '',
});

const errors = ref({});
const isLoading = ref<boolean>();
const storeVariation = () => {
  isLoading.value = true;
  axios.post(`/properties/${props.property.id}/variations`, {
    ...form.value,
    type: props.isOut ? 'out' : 'in'
  }).then(() => {
    emit('close');
    store.refreshProperties()
    errors.value = {};
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    isLoading.value = false;
  })
}
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 left-8 md:left-auto bg-slate-50 dark:bg-stone-900 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 dark:ring-stone-700 ring-1 dark:ring-2 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>{{ isOut ? 'New value decrement' : 'New value increment' }}</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="$emit('close')"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <!-- Main form fields -->
      <form
        class="flex flex-col justify-center items-center gap-4 w-full md:w-96"
        @submit.prevent="storeVariation()"
      >
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
        <submit-button
          class="block w-full"
          :is-loading="isLoading"
        >
          Confirm
        </submit-button>
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
</style>
