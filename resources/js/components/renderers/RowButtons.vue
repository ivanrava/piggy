<script setup lang="ts">
import {computed, ref} from "vue";
import axios from "axios";
import {useOperationsStore} from "../../composables/store";

const store = useOperationsStore()

const props = defineProps<{
  operation: Object
}>()

const isTransfer = computed(() => {
  return 'from' in props.operation || 'to' in props.operation;
})
const endpoint = computed(() => {
  return isTransfer.value ? `/transfers` : `/transactions`;
})

const softDelete = () => {
  if (!confirmDelete.value) {
    confirmDelete.value = true;
    return
  }

  axios.delete(`${endpoint.value}/${props.operation.id}`)
    .then(() => {
      store.deleteOperation(props.operation.id, isTransfer.value)
      confirmDelete.value = false;
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
    @click="softDelete"
  >
    <span class="text-red-900 decoration-red-900">
      {{ confirmDelete ? 'Really sure?' : 'Delete' }}
    </span>
  </a>
</template>

<style scoped>

</style>
