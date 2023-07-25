<template>
  <div class="w-full">
    <div class="w-full flex items-center gap-2">
      <Icon
        v-if="isEdit"
        :class="{'bg-red-400/20': selected === oldIcon}"
        class="text-xl hover:ring-1 ring-red-200/50 hover:shadow-md p-2 w-10 h-10 rounded-xl transition-all cursor-pointer"
        :icon="oldIcon"
        @click="selected = oldIcon; value = oldIcon"
      />
      <form-input
        v-model="prompt"
        class="!w-full"
        label="Icon"
        :errors="errors"
      />
    </div>
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
      v-else-if="!isLoading && total == 0 && prompt.length > 0"
      class="p-3 text-xs opacity-50"
    >
      Nothing found.
    </span>
    <span
      v-else-if="isLoading"
      class="p-3 text-xs opacity-50"
    >
      <i-fa6-solid-circle-notch class="inline animate-spin" />
      Loading
    </span>
    <div
      v-if="actualPages > 1"
      class="flex justify-start mb-1 ml-2"
    >
      <span
        v-for="i in actualPages"
        :key="i"
        :class="{'font-bold !opacity-90 cursor-default': page === i}"
        class="text-xl w-8 h-8 px-2 py-1 transition-all hover:opacity-100 opacity-60 dark:opacity-40 cursor-pointer"
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
        class="text-5xl hover:ring-1 ring-red-200/50 hover:shadow-md p-2 w-12 rounded-xl transition-all cursor-pointer"
        :icon="icon"
        @click="selected = icon; value = icon"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";
import FormInput from "./FormInput.vue";
import {ref, watch, computed, onMounted} from "vue";
import {useDebouncedRef} from "../../../composables/performance";

const prompt = useDebouncedRef('');
const icons = ref([]);
const selected = ref('');
const total = ref(0);
const pageLimit = 32;
const maxPages = 12;
const actualPages = ref(0);
const page = ref(1);
const isLoading = ref(false);
const oldIcon = ref('');

const props = defineProps({
  modelValue: {
    type: String,
  },
  errors: {
    type: Array<String>,
    default: []
  },
  isEdit: {
    type: Boolean,
  }
})

onMounted(() => {
  oldIcon.value = value.value
  selected.value = value.value
})

const emit = defineEmits(['update:modelValue'])
const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})

watch(prompt, async (newPrompt) => {
  if (newPrompt.length > 0) {
    isLoading.value = true;
    try {
      const res = await fetch(`https://api.iconify.design/search?query=${newPrompt} palette=false&limit=${pageLimit * maxPages}`)
      const js = (await res.json());
      icons.value = js['icons']
      total.value = js['total']
      actualPages.value = Math.ceil(total.value / pageLimit)
      page.value = 1;
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
