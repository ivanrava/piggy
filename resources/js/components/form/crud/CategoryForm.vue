<script setup lang="ts">
import {Icon} from "@iconify/vue";
import IconInput from "../inputs/IconInput.vue";
import FormInput from "../inputs/FormInput.vue";
import SelectInput from "../inputs/SelectInput.vue";
import SubmitButton from "../inputs/SubmitButton.vue";
import {onMounted, ref} from "vue";
import axios from "axios";

defineProps({
  showForm: {
    type: Boolean,
  },
  errors : {
    type: Object,
  }
})
defineEmits(['store', 'close'])

const categoryTypes = [
  {
    id: 'out',
    display: 'Expense'
  },
  {
    id: 'in',
    display: 'Income'
  }
]
const fathers = ref([]);
onMounted(() =>  {
  axios.get("/categories").then(({data}) => {
    fathers.value = data.data;
  }).catch(({response}) => {
    console.log(response.data.errors)
  })
});

const form = ref({
  name: '',
  type: 'out',
  icon: '',
  parent_category_id: null
})
</script>

<template>
  <Transition name="slide-fade">
    <aside
      v-if="showForm"
      class="fixed bottom-8 right-8 bg-slate-50 p-4 rounded-2xl drop-shadow-2xl ring-stone-200 ring-1 z-10"
    >
      <header class="flex flex-row justify-between items-center">
        <h2>Add a new category</h2>
        <a
          class="flex flex-row items-center cursor-pointer"
          @click="$emit('close')"
        >
          <span class="mr-1">Close</span>
        </a>
      </header>
      <div
        v-if="form.parent_category_id === null"
        class="button-group"
      >
        <button
          v-for="t in categoryTypes"
          :key="t.id"
          class="m-2 pb-1 border-pink-100/20 text-pink-700/70 font-light border-b-2 transition-all rounded-none hover:border-red-700/60 hover:text-red-700"
          :class="{'!border-pink-700 !text-pink-950 !font-normal': t.id === form.type}"
          @click="form.type = t.id"
        >
          {{ t.display }}
        </button>
      </div>
      <form
        class="flex flex-col justify-center items-center gap-4 w-96"
        @submit.prevent="$emit('store', form)"
      >
        <form-input
          v-model="form.name"
          class="!w-full"
          label="Category name"
          :errors="errors.name"
        />
        <select-input
          v-slot="{ option }"
          v-model="form.parent_category_id"
          :options="fathers"
          name="Parent category"
          :allow-empty="true"
          :errors="errors.parent_category_id"
        >
          <Icon
            :icon="option.icon"
            class="inline mr-1"
          />
          <span class="option__title">{{ option.name }}</span>
        </select-input>
        <icon-input
          v-model="form.icon"
          :errors="errors.icon"
        />
        <submit-button>
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
