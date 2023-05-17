<script lang="ts">
import {defineComponent} from "vue";
import {Icon} from "@iconify/vue";

export default defineComponent({
  name: 'CategoryRenderer',
  components: {Icon},
  props: ['params']
})
</script>

<template>
  <span>
    <Icon :icon="params.value.icon" class="inline mr-1" />
    <span class="font-medium h-1/2">{{ params.value.name }}</span>
  </span>
</template>

<style scoped>

</style>
