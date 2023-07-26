<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import PropertyCard from "../../../components/PropertyCard.vue";
import {Property} from "../../../composables/interfaces";

const isLoading = ref<boolean>(true);
const properties = ref<Array<Property>>([]);
onMounted(() => {
  axios.get('/properties').then(({data}) => {
    properties.value = data.data;
  }).finally(() => {
    isLoading.value = false;
  })
})
</script>

<template>
  <div class="flex-col">
    <h1>Properties</h1>
    <section class="flex flex-col gap-4">
      <PropertyCard
        v-for="property in properties"
        :key="property.id"
        :property="property"
        class="w-full"
      />
    </section>
  </div>
</template>

<style scoped>

</style>
