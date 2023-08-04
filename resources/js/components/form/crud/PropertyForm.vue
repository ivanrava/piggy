<script setup lang="ts">
import {Icon} from "@iconify/vue";
import DecimalInput from "../inputs/DecimalInput.vue";
import FormInput from "../inputs/FormInput.vue";
import IconInput from "../inputs/IconInput.vue";
import FormTextarea from "../inputs/FormTextarea.vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {usePropertyStore} from "../../../composables/usePropertiesStore";
import {ref} from "vue";
import axios from "axios";

const store = usePropertyStore();

const errors = ref({});
const loading = ref(false);
const emit = defineEmits(['store', 'update'])

const storeAccount = function (payload) {
  loading.value = true;
  axios.post("/properties", payload).then(({data}) => {
    store.showForm = false;
    emit('store', data.data)
    store.addProperty(data.data)
    errors.value = [];
  }).catch(({response}) => {
    errors.value = response.data.errors;
  }).finally(() => {
    loading.value = false;
  })
}
const updateAccount = function (payload) {
  loading.value = true;
  axios.put(`/properties/${store.stagingProperty.id}`, payload).then(({data}) => {
    store.showForm = false;
    store.updateProperty(data.data)
    emit('update', data.data)
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
      v-if="store.showForm"
      class="fixed bottom-8 right-8 left-8 md:left-auto bg-slate-50 dark:bg-stone-900 p-4 m-4 rounded-2xl drop-shadow-2xl ring-stone-200 dark:ring-stone-700 ring-1 dark:ring-2 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2 v-if="!store.isEditing">
          Add a new property
        </h2>
        <h2 v-else>
          Edit property
        </h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="store.showForm = false; store.isEditing = false;"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <form
        class="flex flex-col justify-center items-center gap-4 md:w-96 relative"
        @submit.prevent="store.isEditing ? updateAccount(store.stagingProperty) : storeAccount(store.stagingProperty)"
      >
        <div class="w-full flex flex-row justify-between items-start gap-4">
          <form-input
            v-model="store.stagingProperty.name"
            class="!w-full"
            label="Property name"
            :errors="errors.name"
          />
          <decimal-input
            v-model="store.stagingProperty.initial_value"
            :errors="errors.initial_balance"
            label="Initial value"
          />
        </div>
        <icon-input
          v-model="store.stagingProperty.icon"
          :is-edit="store.isEditing"
          :errors="errors.icon"
        />
        <form-textarea
          v-model="store.stagingProperty.description"
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
    :is-loading="loading"
    @click="store.showForm = true; store.isEditing = false; store.emptyForm();"
  >
    <Icon
      icon="mdi:house-add"
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
