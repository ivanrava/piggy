<script lang="ts">
import {defineComponent} from "vue";
import {Icon} from "@iconify/vue";

export default defineComponent({
  name: 'CategoryRenderer',
  components: {Icon},
  props: ['params'],
  computed: {
    category() {
      return 'category' in this.params.data ? this.params.data.category : {
        'icon': 'mingcute:transfer-fill',
        'name': 'Transfer'
      }
    }
  }
})
</script>

<template>
  <span>
    <Icon :icon="category.icon" class="inline mr-1" />
    <span class="font-medium h-1/2">{{ category.name }}</span>
  </span>
</template>

<style scoped>

</style>
