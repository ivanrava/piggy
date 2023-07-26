<script setup lang="ts">
import TopListForm from "./TopListForm.vue";
import StatForm from "./StatForm.vue";
import TopListChart from "./TopListChart.vue";
import {computed, ref} from "vue";
import InOutHistoryForm from "./InOutHistoryForm.vue";
import InOutHistoryChart from "./InOutHistoryChart.vue";
import PieChartWrapper from "./PieChartWrapper.vue";
import PieForm from "./PieForm.vue";
import SideBar from "../../../components/nav/SideBar.vue";

const forms = ref({
  pie: {
    interval: 'year',
    kind: 'pie',
    stat: 'sum',
    filter: 'accounts',
    filter_id: null,
    filter_group: 'accounts'
  },
  list: {
    interval: 'all',
    kind: 'list',
    filter: 'beneficiaries',
    stat: 'sum'
  },
  inOutHistory: {
    interval: 'year',
    stat: 'sum',
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
const stagingForm = computed(() => {
  if (currentForm.value === 'list')
    return forms.value.list
  if (currentForm.value === 'inOutHistory')
    return forms.value.inOutHistory
  if (currentForm.value === 'pie')
    return forms.value.pie

  return {}
})
</script>

<template>
  <div class="h-full flex flex-col justify-between">
    <section class="h-full flex-col overflow-scroll">
      <div class="h-full flex flex-col">
        <aside class="flex justify-center flex-grow items-center flex-1">
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
        <stat-form
          :title="titles[currentForm]"
          :form="stagingForm"
        >
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
        </stat-form>
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
      </div>
    </section>
    <div class="md:hidden mt-4">
      <side-bar class="rounded-xl" />
    </div>
  </div>
</template>

<style scoped>

</style>
