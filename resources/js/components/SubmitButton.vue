<template>
  <button
    class="focus:outline-none transition-all ring-pink-300/20 focus:ring-4"
    :disabled="isDisabled"
    :class="hasDisabledStyle ? 'disabled' : 'active'"
  >
    <slot v-if="!isLoading" />
    <span v-else>
      <i-fa6-solid-circle-notch class="inline animate-spin" />
      Loading
    </span>
  </button>
</template>

<script setup lang="ts">
import {ref, computed} from "vue";

const props = defineProps({
    startsDisabled: {
        type: Boolean,
        default: false
    },
    isLoading: {
        type: Boolean,
        default: false
    }
})

const isDisabled = ref(props.startsDisabled)

const hasDisabledStyle = computed(() => {
    return isDisabled.value || props.isLoading
})
</script>

<style scoped>
button {
    @apply py-3 px-6 rounded-md my-1 transition-all text-slate-50 font-normal;
}
button.active {
    @apply bg-pink-300 hover:bg-pink-100;
}
button.disabled {
    @apply bg-pink-100 opacity-40 cursor-default;
}
</style>
