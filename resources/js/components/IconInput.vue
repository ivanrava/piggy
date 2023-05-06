<template>
  <div class="w-96">
    <form-input
      v-model="prompt"
      class="w-full"
      placeholder="Start searching for an icon"
    />
    <span
      v-if="!isLoading && total >= pageLimit"
      class="p-3 text-xs opacity-50"
    >
      Showing {{ pageLimit }} of {{ total }} icons.
    </span>
    <span
      v-else-if="!isLoading && total <= pageLimit && total > 0"
      class="p-3 text-xs opacity-50"
    >
      Showing {{ total }} icons.
    </span>
    <span
      v-else-if="isLoading"
      class="p-3 text-xs opacity-50"
    >
      <i-fa6-solid-circle-notch class="inline animate-spin" />
      Loading
    </span>
    <div class="flex justify-start mb-1 ml-2" v-if="actualPages > 1">
      <span
        v-for="i in actualPages"
        :key="i"
        :class="{'font-bold opacity-100 cursor-default': page === i}"
        class="text-xl w-8 h-8 px-2 py-1 transition-all hover:opacity-100 opacity-60 cursor-pointer"
        @click="page = i"
      >
        {{ i }}
      </span>
    </div>
    <div class="flex flex-wrap justify-start mt-1">
      <Icon
        v-for="icon in currentPage"
        :key="icon"
        :class="{'bg-red-400/20': selected === icon}"
        class="text-5xl hover:ring-1 ring-red-200/50 hover:shadow-md p-2 rounded-xl transition-all"
        :icon="icon"
        @click="selected = icon"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";
import FormInput from "./FormInput.vue";
import {ref, watch, computed} from "vue";
import {useDebouncedRef} from "../composables/performance";

const prompt = useDebouncedRef('');
const icons = ref([]);
const selected = ref('');
const total = ref(0);
const pageLimit = 32;
const maxPages = 12;
const actualPages = ref(0);
const page = ref(1);
const isLoading = ref(false);

watch(prompt, async (newPrompt) => {
  if (newPrompt.length > 0) {
    isLoading.value = true;
    try {
      const res = await fetch(`https://api.iconify.design/search?query=${newPrompt} palette=false&limit=${pageLimit * maxPages}`)
      const js = (await res.json());
      icons.value = js['icons']
      total.value = js['total']
      actualPages.value = Math.ceil(total.value / pageLimit)
    } catch (error) {
      console.log('Error! Could not reach the API. ' + error)
    }
    isLoading.value = false;
  }
})

const currentPage = computed(() => {
  const idx = page.value-1;
  return icons.value.slice(idx * pageLimit, (idx+1) * pageLimit)
})
</script>

<style scoped>

</style>
