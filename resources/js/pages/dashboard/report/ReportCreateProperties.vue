<script setup lang="ts">
import ReportCreate from "./ReportCreate.vue";
import ReportProperties from "./ReportProperties.vue";
</script>

<template>
  <ReportCreate
    title="Property report"
    url="/report/properties"
  >
    <template #default="slotProps">
      <ReportProperties
        :properties="slotProps.fetchedData"
        :from="slotProps.from"
        :to="slotProps.to"
      />
    </template>
  </ReportCreate>
</template>

<style scoped>

</style>
