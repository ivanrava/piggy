<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import PropertyCard from "../../../components/PropertyCard.vue";
import {Property} from "../../../composables/interfaces";
import PropertyVariationForm from "../../../components/form/crud/PropertyVariationForm.vue";
import {usePropertyStore} from "../../../composables/usePropertiesStore";
import PropertyForm from "../../../components/form/crud/PropertyForm.vue";
import NoData from "../../../components/NoData.vue";

const isLoading = ref<boolean>(true);
const store = usePropertyStore();
onMounted(() => {
  axios.get('/properties').then(({data}) => {
    store.setProperties(data.data);
  }).finally(() => {
    isLoading.value = false;
  })
})

const showVariationForm = ref<boolean>(false);
const isOut = ref<boolean>(false);
const relatedProperty = ref<Property>(null);
</script>

<template>
  <div class="h-full flex flex-col justify-between">
    <section class="overflow-scroll">
      <h1>Properties</h1>
      <Transition
        mode="out-in"
        name="fade-loading"
      >
        <section
          v-if="isLoading"
          class="flex flex-col gap-4"
        >
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-32 dark:bg-gray-500 bg-gray-400/70 rounded-lg" />
          <div class="w-full animate-pulse h-28 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400/70 rounded-lg" />
          <div class="w-full animate-pulse h-28 dark:bg-gray-700 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-32 dark:bg-gray-600 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-28 dark:bg-gray-700 bg-gray-400 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-600 bg-gray-400/70 rounded-lg" />
          <div class="w-full animate-pulse h-24 dark:bg-gray-500 bg-gray-400 rounded-lg" />
        </section>
        <section v-else-if="store.properties.length == 0">
          <no-data class="my-8" />
        </section>
        <section
          v-else
          class="flex flex-col gap-4"
        >
          <PropertyCard
            v-for="property in store.properties"
            :key="property.id"
            :property="property"
            class="w-full"
            @add-in="showVariationForm = true; isOut = false; relatedProperty = property"
            @add-out="showVariationForm = true; isOut = true; relatedProperty = property"
          />
        </section>
      </Transition>
      <PropertyVariationForm
        :show-form="showVariationForm"
        :is-out="isOut"
        :property="relatedProperty"
        @close="showVariationForm = false"
      />
    </section>
    <PropertyForm />
  </div>
</template>

<style scoped>

</style>
