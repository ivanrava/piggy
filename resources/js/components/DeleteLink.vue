<script setup lang="ts">
import ActionLink from "./ActionLink.vue";
import {ref} from "vue";

defineEmits(['delete']);
const showConfirm = ref(false);
</script>

<template>
  <Transition
    mode="out-in"
    name="fade"
  >
    <ActionLink
      v-if="showConfirm"
      :class="{'!decoration-red-900 dark:!decoration-red-400 hover:!decoration-red-800 dark:hover:!decoration-red-300':showConfirm}"
      @click="$emit('delete')"
    >
      <span class="text-red-900 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-all">
        Really sure?
      </span>
    </ActionLink>
    <ActionLink
      v-else
      @click="showConfirm = true"
    >
      <span>
        Delete
      </span>
    </ActionLink>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
