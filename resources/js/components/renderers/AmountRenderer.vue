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
      else {
        // Is transfer
        if ('to' in this.params.data && 'from' in this.params.data) {
          return this.params.data.from.id == this.$route.params.id;
        } else return 'to' in this.params.data;
      }
    },
    checked() {
      return this.params.data.checked
    }
  }
})
</script>

<template>
  <div class="flex flex-row md:justify-end justify-center items-center h-full">
    <span
      :class="[isOut ? 'text-red-700 dark:text-red-400' : 'text-green-700 dark:text-green-400', {'opacity-20': !checked}]"
      class="w-32 flex justify-end px-4"
    >
      <span
        v-if="isOut"
        class="mr-0.5"
      >
        -
      </span>
      <span>
        {{ params.valueFormatted }}
      </span>
    </span>
    <row-buttons :operation="params.data" />
  </div>
</template>

<style scoped>

</style>
