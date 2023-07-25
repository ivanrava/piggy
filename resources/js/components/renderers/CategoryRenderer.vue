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
  <router-link
    v-if="category.id !== undefined"
    :to="`/categories/${category.id}/transactions`"
  >
    <Icon
      :icon="category.icon"
      class="inline mr-1"
    />
    <span class="font-medium h-1/2 text-ssm">{{ category.name }}</span>
  </router-link>
  <div v-else>
    <Icon
      :icon="category.icon"
      class="inline mr-1 dark:text-stone-200"
    />
    <span class="font-medium h-1/2 text-stone-900 dark:text-stone-200 text-ssm">{{ category.name }}</span>
  </div>
</template>

<style scoped>

</style>
