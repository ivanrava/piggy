<template>
  <nav class="bg-stone-300/80 dark:bg-stone-700 h-full overflow-scroll px-4 py-2 dark:text-gray-200">
    <Transition
      mode="out-in"
      name="fade"
    >
      <side-bar-categories v-if="useRoute().path.startsWith('/categories')" />
      <side-bar-accounts v-else-if="useRoute().path.startsWith('/accounts')" />
      <side-bar-beneficiaries v-else-if="useRoute().path.startsWith('/beneficiaries')" />
      <side-bar-reports v-else-if="useRoute().path.startsWith('/report')" />
      <side-bar-stats v-else-if="useRoute().path.startsWith('/charts')" />
    </Transition>
  </nav>
</template>

<script setup lang="ts">
import SideBarCategories from "./SideBarCategories.vue";
import {useRoute} from "vue-router";
import SideBarAccounts from "./SideBarAccounts.vue";
import SideBarBeneficiaries from "./SideBarBeneficiaries.vue";
import SideBarReports from "./SideBarReports.vue";
import SideBarStats from "./SideBarStats.vue";

</script>

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
