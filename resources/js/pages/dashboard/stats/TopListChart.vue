<script setup lang="ts">
import TopListCategory from "./TopListCategory.vue";
import TopListBeneficiary from "./TopListBeneficiary.vue";
import TopListAccount from "./TopListAccount.vue";

defineProps<{
  form: {
    filter: string,
    stat: string,
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
      :stat="form.stat"
    />
    <top-list-category
      v-else-if="form.filter == 'categories'"
      :stat="form.stat"
    />
    <top-list-account
      v-else-if="form.filter == 'accounts'"
      :stat="form.stat"
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
