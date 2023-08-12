<script setup lang="ts">
import {Account} from "../../../composables/interfaces";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import AccountCard from "../../../components/AccountCard.vue";
import {computed} from "vue";

const props = defineProps<{
  accounts: Array<Account>,
  from: string,
  to: string
}>()

const agGridUtilities = useAgGridUtilites();

const from = computed(() => {
  return props.from == '' ? 'Initial balance' : agGridUtilities.dateFormatterBare(from);
})
const to = computed(() => {
  return props.to == '' ? agGridUtilities.dateFormatterBare(new Date()) : agGridUtilities.dateFormatterBare(to);
})
</script>

<template>
  <table class="w-full">
    <thead class="text-blue-900 dark:text-blue-300/70">
      <tr class="border-b-2 border-black text-2xl dark:border-stone-400/30">
        <th class="w-3/6 text-left">
          Property
        </th>
        <th class="w-1/6 text-right text-lg">
          {{ from }}
        </th>
        <th class="w-1/6 text-right text-lg">
          {{ to }}
        </th>
        <th class="w-1/6 text-right">
          Delta
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="account in accounts"
        :key="account.id"
      >
        <td class="pt-1 pb-0.5">
          <div class="flex justify-start">
            <AccountCard
              :account="account"
              :small="true"
              class="py-1 inline"
            />
          </div>
        </td>
        <td class="text-right text-sm">
          {{ agGridUtilities.currencyFormatterBare(account.from_balance) }}
        </td>
        <td class="text-right text-sm">
          {{ agGridUtilities.currencyFormatterBare(account.to_balance) }}
        </td>
        <td class="text-right text-sm">
          {{ agGridUtilities.currencyFormatterBare(account.delta) }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>

</style>
