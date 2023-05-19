<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'AmountRenderer',
  props: ['params'],
  computed: {
    isOut() {
      if ('category' in this.params.data)
        return this.params.data.category.type === 'out'
      else
        return 'to' in this.params.data
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
