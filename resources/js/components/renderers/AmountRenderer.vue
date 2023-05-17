<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'AmountRenderer',
  props: ['params'],
  computed: {
    isOut() {
      return this.params.data.category.type === 'out'
    }
  }
})
</script>

<template>
  <span :class="isOut ? 'text-red-700' : 'text-green-700'">
    <span v-if="isOut" class="mr-0.5">-</span>
    <span>{{ this.params.valueFormatted }}</span>
  </span>
</template>

<style scoped>

</style>
