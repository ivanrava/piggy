<script lang="ts">
import BeneficiaryImage from "../BeneficiaryImage.vue";
import {defineComponent} from "vue";

export default defineComponent({
  name: 'BeneficiaryRenderer',
  components: {BeneficiaryImage},
  props: ['params']
})
</script>

<template>
  <div class="flex items-center">
    <beneficiary-image :beneficiary="params.value" class="!w-12 !h-12" />
    <span class="text-xs font-semibold">{{ params.value.name }}</span>
  </div>
</template>

<style scoped>

</style>
