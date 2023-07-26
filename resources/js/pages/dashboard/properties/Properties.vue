<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import PropertyCard from "../../../components/PropertyCard.vue";
import {Property} from "../../../composables/interfaces";
import PropertyVariationForm from "../../../components/form/crud/PropertyVariationForm.vue";

const isLoading = ref<boolean>(true);
const properties = ref<Array<Property>>([]);
onMounted(() => {
  axios.get('/properties').then(({data}) => {
    properties.value = data.data;
  }).finally(() => {
    isLoading.value = false;
  })
})

const showVariationForm = ref<boolean>(false);
const isOut = ref<boolean>(false);
</script>

<template>
  <div class="flex-col pb-4">
    <h1>Properties</h1>
    <section class="flex flex-col gap-4">
      <PropertyCard
        v-for="property in properties"
        :key="property.id"
        :property="property"
        class="w-full"
        @add-in="showVariationForm = true; isOut = false;"
        @add-out="showVariationForm = true; isOut = true;"
      />
    </section>
    <PropertyVariationForm
      :show-form="showVariationForm"
      :is-out="isOut"
      @close="showVariationForm = false"
    />
  </div>
</template>

<style scoped>

</style>
