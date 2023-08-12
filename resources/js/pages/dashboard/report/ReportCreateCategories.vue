<script setup lang="ts">
import ReportCreate from "./ReportCreate.vue";
import ReportCategories from "./ReportCategories.vue";
</script>

<template>
  <ReportCreate
    title="Report by categories"
    url="/report/categories"
  >
    <template #default="slotProps">
      <report-categories
        :in-categories="slotProps.fetchedData.in"
        :out-categories="slotProps.fetchedData.out"
      />
    </template>
  </ReportCreate>
</template>

<style scoped>

</style>
