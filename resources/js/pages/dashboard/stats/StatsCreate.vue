<script setup lang="ts">
import TopListForm from "./TopListForm.vue";
import StatForm from "./StatForm.vue";
import TopListChart from "./TopListChart.vue";
import {ref} from "vue";
import InOutHistoryForm from "./InOutHistoryForm.vue";
import InOutHistoryChart from "./InOutHistoryChart.vue";

const forms = ref({
  topList: {
    domain: 'beneficiaries'
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
const currentForm = ref('topList');
const titles = {
  topList: 'Top List',
  inOutHistory: 'In/Out History'
}
</script>

<template>
  <div class="h-full flex flex-col">
    <aside class="flex justify-center flex-grow items-center">
      <top-list-chart
        v-if="currentForm === 'topList'"
        :form="forms.topList"
      />
      <in-out-history-chart
        v-else-if="currentForm === 'inOutHistory'"
        :form="forms.inOutHistory"
      />
    </aside>
    <stat-form :title="titles[currentForm]">
      <top-list-form
        v-if="currentForm === 'topList'"
        v-model="forms.topList"
      />
      <in-out-history-form
        v-else-if="currentForm === 'inOutHistory'"
        v-model="forms.inOutHistory"
      />
      <div class="flex justify-between mt-3.5">
        <a
          class="cursor-pointer"
          @click="currentForm = 'topList'"
        >&#10094; Previous statistic</a>
        <a
          class="cursor-pointer"
          @click="currentForm = 'inOutHistory'"
        >Next statistic &#10095;</a>
      </div>
    </stat-form>
  </div>
</template>

<style scoped>

</style>
