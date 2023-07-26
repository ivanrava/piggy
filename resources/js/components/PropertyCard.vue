<script setup lang="ts">
import {Property} from "../composables/interfaces";
import {Icon} from "@iconify/vue";
import SubmitButton from "./form/inputs/SubmitButton.vue";
import {useAgGridUtilites} from "../composables/useAgGridUtilities";
import PropertyVariationsTable from "./PropertyVariationsTable.vue";

defineProps<{
  property: Property
}>()

defineEmits(['addIn', 'addOut'])
</script>

<template>
  <article class="bg-stone-100 dark:bg-stone-900/50 p-4 rounded-xl shadow-sm flex flex-col gap-4">
    <div class="flex flex-row justify-between items-center">
      <div>
        <h2 class="font-semibold flex flex-row gap-2 items-center my-1">
          <Icon :icon="property.icon" />
          <span>{{ property.name }}</span>
        </h2>
        <p>
          {{ property.description }}
        </p>
      </div>
      <div class="flex flex-row w-1/4 gap-2">
        <div class="button-wrapper">
          <SubmitButton
            class="new-variation-button"
            @click="$emit('addOut')"
          >
            <Icon icon="typcn:minus" />
          </SubmitButton>
        </div>
        <div class="flex flex-col justify-center flex-1">
          <span class="text-2xl bg-stone-200 dark:bg-stone-700/50 p-0.5 pr-4 rounded-md text-right font-mono">
            {{ useAgGridUtilites().currencyFormatterBare(property.value) }}
          </span>
        </div>
        <div class="button-wrapper">
          <SubmitButton
            class="new-variation-button"
            @click="$emit('addIn')"
          >
            <Icon icon="typcn:plus" />
          </SubmitButton>
        </div>
      </div>
    </div>
    <div
      v-if="property.variations.length > 0"
      class="bg-stone-200 dark:bg-stone-700/50 p-4 rounded-md"
    >
      <PropertyVariationsTable
        :property="property"
        class="w-full"
      />
    </div>
  </article>
</template>

<style scoped>
.button-wrapper {
  @apply flex flex-col justify-center;
}
.new-variation-button {
  @apply text-3xl !p-1;
}
</style>
