<script lang="ts">
import {defineComponent} from "vue";
import AccountCard from "../AccountCard.vue";

export default defineComponent({
  name: 'AccountRenderer',
  components: {AccountCard},
  props: ['params'],
})
</script>

<template>
  <div class="flex items-center">
    <account-card
      :account="params.data.account"
      :small="true"
      class="!h-9 leading-normal my-1 mx-2 drop-shadow-sm"
    />
  </div>
</template>

<style scoped>

</style>
