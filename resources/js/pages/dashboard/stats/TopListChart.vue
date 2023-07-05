<script setup lang="ts">
import TopListCategory from "./TopListCategory.vue";
import TopListBeneficiary from "./TopListBeneficiary.vue";
import TopListAccount from "./TopListAccount.vue";

defineProps<{
  form: {
    favorite: boolean
    filter: string,
    stat: string,
    interval: string
  }
}>();
</script>

<template>
  <Transition
    mode="out-in"
    name="fade"
  >
    <top-list-beneficiary
      v-if="form.filter == 'beneficiaries'"
      :favorite="form.favorite"
      :stat="form.stat"
      :interval="form.interval"
    />
    <top-list-category
      v-else-if="form.filter == 'categories'"
      :favorite="form.favorite"
      :stat="form.stat"
      :interval="form.interval"
    />
    <top-list-account
      v-else-if="form.filter == 'accounts'"
      :favorite="form.favorite"
      :stat="form.stat"
      :interval="form.interval"
    />
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
