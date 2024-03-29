<script setup lang="ts">
import {Property} from "../composables/interfaces";
import {Icon} from "@iconify/vue";
import SubmitButton from "./form/inputs/SubmitButton.vue";
import {useAgGridUtilites} from "../composables/useAgGridUtilities";
import PropertyVariationsTable from "./PropertyVariationsTable.vue";
import ActionLink from "./ActionLink.vue";
import {usePropertyStore} from "../composables/usePropertiesStore";
import DeleteLink from "./DeleteLink.vue";
import axios from "axios";

defineProps<{
  property: Property
}>()

const store = usePropertyStore();

defineEmits(['addIn', 'addOut'])

const deleteProperty = (property: Property) => {
  axios.delete(`/properties/${property.id}`)
    .then(() => {
      store.deleteProperty(property)
    })
    .catch((res) => {
      console.log(res)
    })
}
</script>

<template>
  <article class="bg-stone-100 dark:bg-stone-900/50 p-4 rounded-xl shadow-sm flex flex-col gap-4">
    <div class="flex flex-col lg:flex-row justify-between items-center gap-4 xl:gap-0">
      <div class="lg:w-1/2 xl:w-auto">
        <div class="flex gap-2 items-center">
          <h2 class="font-semibold flex flex-row gap-2 items-center my-1">
            <Icon :icon="property.icon" />
            <span>{{ property.name }}</span>
          </h2>
          <ActionLink @click="store.editProperty(property)">
            Edit
          </ActionLink>
          <DeleteLink @delete="deleteProperty(property)" />
        </div>
        <p>
          {{ property.description }}
        </p>
      </div>
      <div class="flex flex-row w-full lg:w-1/2 xl:w-1/3 2xl:w-1/4 gap-2">
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
