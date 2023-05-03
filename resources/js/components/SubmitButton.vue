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
    @apply p-2 rounded-md m-1 transition-all w-32;
}
button.active {
    @apply bg-amber-200 hover:bg-amber-400;
}
button.disabled {
    @apply bg-amber-200 opacity-40 cursor-default;
}
</style>
