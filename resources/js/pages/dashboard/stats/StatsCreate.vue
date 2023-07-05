<script setup lang="ts">
import TopListForm from "./TopListForm.vue";
import StatForm from "./StatForm.vue";
import TopListChart from "./TopListChart.vue";
import {computed, ref} from "vue";
import InOutHistoryForm from "./InOutHistoryForm.vue";
import InOutHistoryChart from "./InOutHistoryChart.vue";

const forms = ref({
  list: {
    filter: 'beneficiaries',
    stat: 'sum'
  },
  inOutHistory: {
    interval: 'year',
    isLine: false,
    filter: 'all',
    filterObj: {
      id: null,
      name: ''
    }
  }
});
const currentFormIndex = ref(0);
const availableForms = computed(() => {
  return Object.keys(forms.value);
})
const currentForm = computed(() => {
  return availableForms.value[currentFormIndex.value];
})
const titles = {
  list: 'Top List',
  inOutHistory: 'In/Out History'
}
const disabledClassesIf = (disabledCondition: boolean) => {
  return disabledCondition ? 'disabled' : 'cursor-pointer';
}
</script>

<template>
  <div class="h-full flex flex-col">
    <aside class="flex justify-center flex-grow items-center">
      <top-list-chart
        v-if="currentForm === 'list'"
        :form="forms.list"
      />
      <in-out-history-chart
        v-else-if="currentForm === 'inOutHistory'"
        :form="forms.inOutHistory"
      />
    </aside>
    <stat-form :title="titles[currentForm]">
      <top-list-form
        v-if="currentForm === 'list'"
        v-model="forms.list"
      />
      <in-out-history-form
        v-else-if="currentForm === 'inOutHistory'"
        v-model="forms.inOutHistory"
      />
      <div class="flex justify-between mt-3.5">
        <a
          :class="disabledClassesIf(currentFormIndex == 0)"
          @click="currentFormIndex = currentFormIndex == 0 ? currentFormIndex : currentFormIndex-1"
        >&#10094; Previous statistic</a>
        <a
          :class="disabledClassesIf(currentFormIndex == availableForms.length-1)"
          @click="currentFormIndex = currentFormIndex == availableForms.length-1 ? currentFormIndex : currentFormIndex+1"
        >Next statistic &#10095;</a>
      </div>
    </stat-form>
  </div>
</template>

<style scoped>

</style>
