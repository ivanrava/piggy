<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import axios from "axios";

const props = defineProps<{
  title: string
  favorite: boolean
  id: number
}>();

const toggle = ref(false);
const isLoading = ref(false);
const toggleFavorite = () => {
  if (isLoading.value)
    return

  isLoading.value = true;
  toggle.value = !toggle.value;
  axios.put(`/charts/${props.id}`)
    .catch((error) => {
      console.log(error)
    })
    .finally(() => {
      isLoading.value = false;
  })
}
</script>

<template>
  <article class="p-2 md:w-1/2 xl:w-1/3 2xl:w-1/4 h-72">
    <div class="p-4 bg-stone-50/90 dark:bg-pink-950/50 shadow-md rounded-md flex h-full flex-col w-full">
      <div class="flex justify-between items-baseline">
        <h2 class="text-xl">
          {{ title }}
        </h2>
        <Icon
          :icon="(toggle ? !favorite : favorite) ? 'fe:star' : 'mdi-light:star'"
          class="text-lg cursor-pointer transition-all"
          :class="(toggle ? !favorite : favorite) ? 'opacity-80 hover:opacity-50' : 'opacity-50 hover:opacity-90'"
          @click="toggleFavorite"
        />
      </div>
      <div class="overflow-auto flex-grow flex justify-center items-center">
        <slot />
      </div>
    </div>
  </article>
</template>

<style scoped>

</style>
