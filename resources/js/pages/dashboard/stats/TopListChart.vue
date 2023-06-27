<script setup lang="ts">
import TopListCategory from "./TopListCategory.vue";
import TopListBeneficiary from "./TopListBeneficiary.vue";

defineProps<{
  form: {
    domain: String
  }
}>();
</script>

<template>
  <Transition
    mode="out-in"
    name="fade"
  >
    <top-list-beneficiary v-if="form.domain == 'beneficiaries'" />
    <top-list-category v-else-if="form.domain == 'categories'" />
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
