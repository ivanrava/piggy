<script setup lang="ts">
import {computed, ref} from "vue";
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
  if (!confirmDelete.value)
    confirmDelete.value = true;

  axios.delete(`${endpoint.value}/${props.operation.id}`)
    .then(() => {
      emit('deleted')
    })
    .catch((res) => {
      console.log(res)
    })
}
const confirmDelete = ref(false);
</script>

<template>
  <a
    class="cursor-pointer flex flex-col justify-center"
    role="button"
    @click="deleteOperation"
  >
    <span class="text-red-900 decoration-red-900">
      {{ confirmDelete ? 'Really sure?' : 'Delete' }}
    </span>
  </a>
</template>

<style scoped>

</style>
