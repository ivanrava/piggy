<script setup lang="ts">
import DecimalInput from "../../../components/form/inputs/DecimalInput.vue";
import {ref} from "vue";
import TabSelector from "../../../components/form/inputs/TabSelector.vue";
import {computed} from "vue";

const options = ref([
  {
    id: 'overall',
    type: 'Yearly overall'
  },
  {
    id: 'fixed',
    type: 'Monthly fixed'
  },
  {
    id: 'custom',
    type: 'Monthly custom'
  }
]);

const props = defineProps<{
  modelValue: {
    budget_type: string;
    budget_overall: number,
    budget: {
      jan: string;
      feb: string;
      mar: string;
      apr: string;
      may: string;
      jun: string;
      jul: string;
      aug: string;
      sep: string;
      oct: string;
      nov: string;
      dec: string;
    }
  },
  errors: {
    budget_overall: string,
    budget: {
      jan: string;
      feb: string;
      mar: string;
      apr: string;
      may: string;
      jun: string;
      jul: string;
      aug: string;
      sep: string;
      oct: string;
      nov: string;
      dec: string;
    }
  }
}>()
const emit = defineEmits(['update:modelValue'])

const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})
</script>

<template>
  <section class="w-full flex flex-col gap-2">
    <tab-selector
      v-model="value.budget_type"
      :tabs="options"
      label="Budget type"
    />
    <div class="w-full">
      <Transition
        mode="out-in"
        name="fade-quick"
      >
        <decimal-input
          v-if="value.budget_type === 'overall'"
          v-model="value.budget_overall"
          :errors="errors.budget_overall"
          class="!w-full px-1"
          label="Yearly overall"
        />
        <decimal-input
          v-else-if="value.budget_type === 'fixed'"
          v-model="value.budget_overall"
          :errors="errors.budget_overall"
          class="!w-full px-1"
          label="Monthly fixed"
        />
        <div
          v-else
          class="w-full flex flex-row flex-wrap"
        >
          <decimal-input
            v-model="value.budget.jan"
            class="!w-1/3 px-1"
            label="January"
          />
          <decimal-input
            v-model="value.budget.feb"
            class="!w-1/3 px-1"
            label="February"
          />
          <decimal-input
            v-model="value.budget.mar"
            class="!w-1/3 px-1"
            label="March"
          />
          <decimal-input
            v-model="value.budget.apr"
            class="!w-1/3 px-1"
            label="April"
          />
          <decimal-input
            v-model="value.budget.may"
            class="!w-1/3 px-1"
            label="May"
          />
          <decimal-input
            v-model="value.budget.jun"
            class="!w-1/3 px-1"
            label="June"
          />
          <decimal-input
            v-model="value.budget.jul"
            class="!w-1/3 px-1"
            label="July"
          />
          <decimal-input
            v-model="value.budget.aug"
            class="!w-1/3 px-1"
            label="August"
          />
          <decimal-input
            v-model="value.budget.sep"
            class="!w-1/3 px-1"
            label="September"
          />
          <decimal-input
            v-model="value.budget.oct"
            class="!w-1/3 px-1"
            label="October"
          />
          <decimal-input
            v-model="value.budget.nov"
            class="!w-1/3 px-1"
            label="November"
          />
          <decimal-input
            v-model="value.budget.dec"
            class="!w-1/3 px-1"
            label="December"
          />
        </div>
      </Transition>
    </div>
  </section>
</template>

<style scoped>
.fade-quick-enter-active,
.fade-quick-leave-active {
  transition: opacity 0.2s ease;
}

.fade-quick-enter-from,
.fade-quick-leave-to {
  opacity: 0;
}
</style>
