<script lang="ts">
import BeneficiaryImage from "../BeneficiaryImage.vue";
import {defineComponent} from "vue";
import AccountCard from "../AccountCard.vue";

export default defineComponent({
  name: 'BeneficiaryRenderer',
  components: {AccountCard, BeneficiaryImage},
  props: ['params'],
  computed: {
    isBeneficiary() {
      return 'beneficiary' in this.params.data;
    },
    beneficiary() {
      return this.params.data.beneficiary;
    },
    account() {
      return 'to' in this.params.data ? this.params.data.to : this.params.data.from;
    }
  }
})
</script>

<template>
  <div
    v-if="isBeneficiary"
    class="flex items-center"
  >
    <beneficiary-image
      :beneficiary="beneficiary"
      class="!w-12 !h-12"
    />
    <span class="text-xs font-semibold">{{ beneficiary.name }}</span>
  </div>
  <div
    v-else
    class="flex items-center"
  >
    <account-card
      :account="account"
      :small="true"
      class="!h-9 leading-normal my-1 mx-2 drop-shadow-sm"
    />
  </div>
</template>

<style scoped>

</style>
