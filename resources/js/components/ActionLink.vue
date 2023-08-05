<script setup lang="ts">
defineEmits(['click'])
</script>

<template>
  <a
    class="cursor-pointer flex flex-col justify-center !text-lg ptx-2 font-extralight"
    role="button"
    @click="$emit('click')"
  >
    <span>
      <slot />
    </span>
  </a>
</template>

<style scoped>

</style>
