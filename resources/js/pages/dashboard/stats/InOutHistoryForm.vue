<script setup lang="ts">
import {computed, onMounted, ref, watch} from "vue";
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";
import RadioInput from "../../../components/form/inputs/RadioInput.vue";
import SelectInput from "../../../components/form/inputs/SelectInput.vue";
import {Icon} from "@iconify/vue";
import axios from "axios";
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";

const props = defineProps({
  modelValue: {
    type: Object,
  }
})
const emit = defineEmits(['update:modelValue'])

const form = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})
const options = ref([
  {id:'month',display:'Monthly'},
  {id:'year',display:'Yearly'},
])

const accounts = ref([]);
const account_id = ref(null);
const beneficiaries = ref([]);
const beneficiary_id = ref(null);
const categories = ref([]);
const category_id = ref(null);
const errors = ref({});
onMounted(() => {
  // Fetch categories
  axios.get("/categories").then(({data}) => {
    categories.value = data.data;
    category_id.value = categories.value[0].id;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch beneficiaries
  axios.get("/beneficiaries").then(({data}) => {
    beneficiaries.value = data.data;
    beneficiary_id.value = beneficiaries.value[0].id;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch accounts
  axios.get("/accounts").then(({data}) => {
    accounts.value = data.data;
    account_id.value = accounts.value[0].id;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
})

const updateId = () => {
  if (form.value.filter === 'accounts')
    form.value.filterObj = accounts.value.filter(acc => acc.id === account_id.value)[0]
  else if (form.value.filter === 'beneficiaries')
    form.value.filterObj = beneficiaries.value.filter(ben => ben.id === beneficiary_id.value)[0]
  else if (form.value.filter === 'categories')
    form.value.filterObj = categories.value.filter(cat => cat.id === category_id.value)[0]
}
watch(form, updateId, {deep: true})
watch(account_id, updateId)
watch(category_id, updateId)
watch(beneficiary_id, updateId)
</script>

<template>
  <p>
    Through this component you can easily gauge your expenses and incomes trends.
  </p>
  <div class="flex gap-20">
    <radio-input
      v-model="form.interval"
      label="Interval"
      :options="options"
    />
    <radio-input
      v-model="form.isLine"
      label="Kind"
      :options="[{id:true,display:'Line'},{id:false,display:'Bar'}]"
    />
    <radio-input
      v-model="form.filter"
      label="Filter by"
      :options="[{id:'all',display:'All'},{id:'accounts',display:'Account'},{id:'categories',display:'Category'},{id:'beneficiaries',display:'Beneficiary'}]"
    />
    <Transition
      mode="out-in"
      name="fade"
    >
      <select-input
        v-if="form.filter === 'accounts'"
        v-slot="{option}"
        v-model="account_id"
        :options="accounts"
        name="Account"
        class="!w-96"
      >
        <Icon
          :icon="option.icon"
          class="inline mr-1"
        />
        <span
          class="option__title text-sm"
        >
          {{ option.name }}
        </span>
      </select-input>
      <select-input
        v-else-if="form.filter === 'beneficiaries'"
        v-slot="{option}"
        v-model="beneficiary_id"
        :options="beneficiaries"
        name="Beneficiary"
        :errors="errors.beneficiary"
        class="!w-96"
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
        v-else-if="form.filter === 'categories'"
        v-slot="{option}"
        v-model="category_id"
        :options="categories"
        name="Category"
        :errors="errors.category"
        class="!w-96"
      >
        <Icon
          :icon="option.icon"
          class="inline mr-1"
        />
        <span class="option__title text-sm">{{ option.name }}</span>
      </select-input>
      <div
        v-else
        class="!w-96"
      />
    </Transition>
  </div>
  <submit-button>Add statistic</submit-button>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.1s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>