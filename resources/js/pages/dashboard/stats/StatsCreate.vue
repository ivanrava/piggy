<script setup lang="ts">
import TopListForm from "./TopListForm.vue";
import StatForm from "./StatForm.vue";
import TopListChart from "./TopListChart.vue";
import {computed, ref} from "vue";
import InOutHistoryForm from "./InOutHistoryForm.vue";
import InOutHistoryChart from "./InOutHistoryChart.vue";
import PieChartWrapper from "./PieChartWrapper.vue";
import PieForm from "./PieForm.vue";

const forms = ref({
  pie: {
    interval: 'year',
    stat: 'sum',
    filter: 'accounts',
    filter_id: null,
    filter_group: 'accounts'
  },
  list: {
    interval: 'all',
    filter: 'beneficiaries',
    stat: 'sum'
  },
  inOutHistory: {
    interval: 'year',
    // TODO: insert stat
    kind: 'line',
    filter: 'all',
    filter_id: null,
  },
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
  inOutHistory: 'In/Out History',
  pie: 'Pie Chart'
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
      <pie-chart-wrapper
        v-else-if="currentForm === 'pie'"
        :form="forms.pie"
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
      <pie-form
        v-else-if="currentForm === 'pie'"
        v-model="forms.pie"
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
