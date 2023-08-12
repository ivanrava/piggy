<script setup lang="ts">
import ReportCreate from "./ReportCreate.vue";
import ReportAccounts from "./ReportAccounts.vue";
</script>

<template>
  <ReportCreate
    title="Account report"
    url="/report/accounts"
  >
    <template #default="slotProps">
      <ReportAccounts
        :accounts="slotProps.fetchedData"
        :from="slotProps.from"
        :to="slotProps.to"
      />
    </template>
  </ReportCreate>
</template>

<style scoped>

</style>
