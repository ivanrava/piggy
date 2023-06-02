<script setup lang="ts">
import {computed} from "vue";
import axios from "axios";

const props = defineProps<{
  operation: Object
}>()
const emit = defineEmits(['deleted'])

const endpoint = computed(() => {
  console.log(props.operation)
  return 'from' in props.operation || 'to' in props.operation ? `/transfers` : `/transactions`;
})

const deleteOperation = () => {
  axios.delete(`${endpoint.value}/${props.operation.id}`)
    .then(() => {
      emit('deleted')
    })
    .catch((res) => {
      console.log(res)
    })
}
</script>

<template>
  <a
    class="cursor-pointer flex flex-col justify-center"
    role="button"
    @click="deleteOperation"
  >
    <span class="text-red-900 decoration-red-900">
      Delete
    </span>
  </a>
</template>

<style scoped>

</style>
