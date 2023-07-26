<script setup lang="ts">
import {Property} from "../composables/interfaces";
import {Icon} from "@iconify/vue";
import SubmitButton from "./form/inputs/SubmitButton.vue";
import {useAgGridUtilites} from "../composables/useAgGridUtilities";

defineProps<{
  property: Property
}>()

defineEmits(['addIn', 'addOut'])
</script>

<template>
  <article class="bg-stone-900/50 p-4 rounded-xl shadow-sm flex flex-row justify-between">
    <div>
      <h2 class="flex flex-row gap-2 items-center font-semibold">
        <Icon :icon="property.icon" />
        <span>{{ property.name }}</span>
      </h2>
      <p>
        {{ property.description }}
      </p>
    </div>
    <div class="flex flex-row w-1/5 gap-2">
      <div class="button-wrapper">
        <SubmitButton
          class="new-variation-button"
          @click="$emit('addOut')"
        >
          <Icon icon="typcn:minus" />
        </SubmitButton>
      </div>
      <div class="flex flex-col justify-center flex-1">
        <span class="text-3xl bg-stone-700/50 p-0.5 pr-3 rounded-md text-right font-mono">
          {{ useAgGridUtilites().currencyFormatterBare(property.initial_value) }}
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
