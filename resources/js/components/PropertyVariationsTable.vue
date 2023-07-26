<script setup lang="ts">
import {Property} from "../composables/interfaces";
import {useAgGridUtilites} from "../composables/useAgGridUtilities";

defineProps<{
  property: Property
}>()
</script>

<template>
  <table>
    <thead class="border-b-2 border-stone-400 dark:border-stone-600">
      <tr>
        <th
          scope="col"
          class="text-left"
        >
          Notes
        </th>
        <th
          scope="col"
          class="text-right"
        >
          Date
        </th>
        <th
          scope="col"
          class="text-right"
        >
          Amount
        </th>
        <th
          scope="col"
          class="text-right"
        >
          Value
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td />
        <td />
        <td />
        <td class="text-right font-mono">
          {{ useAgGridUtilites().currencyFormatterBare(Number(property.initial_value)) }}
        </td>
      </tr>
      <tr
        v-for="variation in property.variations"
        :key="variation.id"
      >
        <td class="italic w-3/4 text-xs">
          <span
            v-if="variation.notes == null"
            class="text-stone-500 dark:text-stone-400"
          >
            (Empty notes)
          </span>
          <span v-else>
            {{ variation.notes }}
          </span>
        </td>
        <td class="text-right text-sm">
          {{ useAgGridUtilites().dateFormatterBare(variation.date) }}
        </td>
        <td class="text-right font-mono">
          <span :class="variation.type == 'out' ? 'text-red-700 dark:text-red-400' : 'text-green-700 dark:text-green-400'">
            {{ variation.type == 'out' ? '-' : '' }}{{ useAgGridUtilites().currencyFormatterBare(variation.amount) }}
          </span>
        </td>
        <td class="text-right font-mono">
          {{ useAgGridUtilites().currencyFormatterBare(variation.value) }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>
td,th {
  @apply p-0;
}
</style>
