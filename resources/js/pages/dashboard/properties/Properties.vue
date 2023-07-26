<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import PropertyCard from "../../../components/PropertyCard.vue";
import {Property} from "../../../composables/interfaces";
import PropertyVariationForm from "../../../components/form/crud/PropertyVariationForm.vue";
import {usePropertyStore} from "../../../composables/usePropertiesStore";
import PropertyForm from "../../../components/form/crud/PropertyForm.vue";

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
  <div class="flex-col pb-4">
    <h1>Properties</h1>
    <section class="flex flex-col gap-4">
      <PropertyCard
        v-for="property in store.properties"
        :key="property.id"
        :property="property"
        class="w-full"
        @add-in="showVariationForm = true; isOut = false; relatedProperty = property"
        @add-out="showVariationForm = true; isOut = true; relatedProperty = property"
      />
    </section>
    <PropertyVariationForm
      :show-form="showVariationForm"
      :is-out="isOut"
      :property="relatedProperty"
      @close="showVariationForm = false"
    />
    <PropertyForm />
  </div>
</template>

<style scoped>

</style>
