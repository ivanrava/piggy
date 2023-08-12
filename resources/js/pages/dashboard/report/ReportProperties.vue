<script setup lang="ts">
import {Property} from "../../../composables/interfaces";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {Icon} from "@iconify/vue";
import {computed} from "vue";

const props = defineProps<{
  properties: Array<Property>,
  from: string,
  to: string
}>()

const agGridUtilities = useAgGridUtilites();

const from = computed(() => {
  return props.from == '' ? 'Initial value' : agGridUtilities.dateFormatterBare(from);
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
        v-for="property in properties"
        :key="property.id"
      >
        <td class="pt-1 pb-0.5">
          <div class="flex justify-start items-center gap-1 font-semibold">
            <Icon :icon="property.icon" />
            <span>{{ property.name }}</span>
          </div>
        </td>
        <td class="text-right text-sm">
          {{ agGridUtilities.currencyFormatterBare(property.from_value) }}
        </td>
        <td class="text-right text-sm">
          {{ agGridUtilities.currencyFormatterBare(property.to_value) }}
        </td>
        <td class="text-right text-sm">
          {{ agGridUtilities.currencyFormatterBare(property.delta) }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>

</style>
