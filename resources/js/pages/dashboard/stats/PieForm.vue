<script setup lang="ts">
import {computed, ref} from "vue";
import RadioInput from "../../../components/form/inputs/RadioInput.vue";
import SelectInput from "../../../components/form/inputs/SelectInput.vue";
import {Icon} from "@iconify/vue";
import BeneficiaryImage from "../../../components/BeneficiaryImage.vue";
import {onMounted, watch} from "vue";
import axios from "axios";
import SubmitButton from "../../../components/form/inputs/SubmitButton.vue";

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
const optionsStats = ref([
  {id:'sum',display:'Sum'},
  {id:'count',display:'Count'},
  {id:'avg',display:'Average'},
  {id:'max',display:'Maximum'},
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
  axios.get("/categories/leaves").then(({data}) => {
    categories.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch beneficiaries
  axios.get("/beneficiaries").then(({data}) => {
    beneficiaries.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
  // Fetch accounts
  axios.get("/accounts").then(({data}) => {
    accounts.value = data.data;
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
})

const updateId = (newFilter) => {
  if (newFilter === 'accounts')
    form.value.filter_id = account_id.value
  else if (newFilter === 'beneficiaries')
    form.value.filter_id = beneficiary_id.value
  else if (newFilter === 'categories')
    form.value.filter_id = category_id.value
}
watch(() => form.value.filter, updateId, {deep: true})
watch(account_id, (newId) => form.value.filter_id = newId)
watch(category_id, (newId) => form.value.filter_id = newId)
watch(beneficiary_id, (newId) => form.value.filter_id = newId)


const groupOptions = computed(() => {
  return [{id:'accounts',display:'Account'},{id:'categories',display:'Category'},{id:'beneficiaries',display:'Beneficiary'}].filter(value => value.id != form.value.filter);
})
const showGroupRadio = (filter) => {
  return filter === 'accounts' && account_id.value != null || filter === 'categories' && category_id.value != null || filter === 'beneficiaries' && beneficiary_id.value != null
}
watch(() => form.value.filter, (newFilter) => {
  if (showGroupRadio(newFilter))
    form.value.filter_group = groupOptions.value[0].id;
}, {deep: true})
watch(() => form.value.filter_id, () => {
  if (showGroupRadio(form.value.filter))
    form.value.filter_group = groupOptions.value[0].id;
}, {deep: true})
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
      v-model="form.stat"
      label="Statistic"
      :options="optionsStats"
    />
  </div>
  <div class="flex gap-20">
    <radio-input
      v-model="form.filter"
      label="Filter by"
      :options="[{id:'accounts',display:'Account'},{id:'categories',display:'Category'},{id:'beneficiaries',display:'Beneficiary'}]"
    />
    <Transition
      mode="out-in"
      name="fade"
    >
      <select-input
        v-if="form.filter === 'accounts'"
        v-slot="{option}"
        v-model="account_id"
        :allow-empty="true"
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
        :allow-empty="true"
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
        :allow-empty="true"
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
    <radio-input
      v-if="showGroupRadio(form.filter)"
      v-model="form.filter_group"
      label="Group by"
      :options="groupOptions"
    />
  </div>
  <submit-button>Add statistic</submit-button>
</template>

<style scoped>

</style>
