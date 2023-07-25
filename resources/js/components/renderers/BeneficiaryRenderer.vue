<script lang="ts">
import BeneficiaryImage from "../BeneficiaryImage.vue";
import {defineComponent} from "vue";
import AccountCard from "../AccountCard.vue";
import useOperationHelpers from "../../composables/useOperationHelpers";

export default defineComponent({
  name: 'BeneficiaryRenderer',
  components: {AccountCard, BeneficiaryImage},
  props: {
    params: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  computed: {
    isBeneficiary() {
      return 'beneficiary' in this.params.data;
    },
    beneficiary() {
      return this.params.data.beneficiary;
    },
    account() {
      return useOperationHelpers.getOtherAccount(this.params.data, this.$route.params.id)
    }
  }
})
</script>

<template>
  <router-link
    v-if="isBeneficiary"
    class="flex items-center"
    :to="`/beneficiaries/${beneficiary.id}/transactions`"
  >
    <beneficiary-image
      :beneficiary="beneficiary"
      class="!w-12 !h-12"
    />
    <span class="text-ssm font-semibold text-slate-900 dark:text-gray-200">{{ beneficiary.name }}</span>
  </router-link>
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
