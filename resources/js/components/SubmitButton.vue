<template>
    <button :disabled="isDisabled"
            :class="hasDisabledStyle ? 'disabled' : 'active'"
            @click="isLoading=true">
        <slot v-if="!isLoading"></slot>
        <span v-else>Loading</span>
    </button>
</template>

<script setup lang="ts">
import {ref, computed} from "vue";

const props = defineProps({
    startsDisabled: {
        type: Boolean,
        default: false
    },
})

const isDisabled = ref(props.startsDisabled)
const isLoading = ref(false)

const hasDisabledStyle = computed(() => {
    return isDisabled.value || isLoading.value
})
</script>

<style scoped>
button {
    @apply py-4 px-8 rounded-md m-1 transition-all text-slate-50;
}
button.active {
    @apply bg-pink-800 hover:bg-pink-700;
}
button.disabled {
    @apply bg-pink-400 opacity-40 cursor-default;
}
</style>
