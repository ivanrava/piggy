<template>
    <input v-model="value" :placeholder="placeholder" :name="name" :type="type" />
    <ul>
        <li v-for="error in errors" class="text-left text-xs text-red-400">
            {{ error }}
        </li>
    </ul>
</template>

<script setup lang="ts">
import {computed, ref} from "vue";

const props = defineProps({
    modelValue: {
        type: String,
    },
    placeholder: {
        type: String,
        default: null
    },
    name: {
        type: String,
    },
    type: {
        type: String,
        default: 'text'
    }
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

const errors = ref([])
</script>

<style scoped>
input {
    @apply p-2 bg-slate-100 my-1 w-64 rounded-sm text-sm font-mono;
}
</style>
