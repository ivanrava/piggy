<script lang="ts">
import {defineComponent} from "vue";
import RowButtons from "./RowButtons.vue";

export default defineComponent({
  name: 'AmountRenderer',
  components: {RowButtons},
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
  <div class="flex flex-row justify-between items-center">
    <span :class="isOut ? 'text-red-700' : 'text-green-700'">
      <span
        v-if="isOut"
        class="mr-0.5"
      >
        -
      </span>
      <span>{{ params.valueFormatted }}</span>
    </span>
    <row-buttons :operation="params.data" />
  </div>
</template>

<style scoped>

</style>
