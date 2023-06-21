<script setup lang="ts">
import {computed, ref} from "vue";
import axios from "axios";
import {useOperationsStore} from "../../composables/useOperationsStore";
import {Transaction, Transfer} from "../../composables/interfaces";
import {useRoute} from "vue-router";

const store = useOperationsStore()

const props = defineProps<{
  operation: Transaction|Transfer
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

const edit = () => {
  store.showEdit(props.operation, isTransfer.value)
}
</script>

<template>
  <div class="flex flex-row justify-center items-center gap-2">
    <a
      v-if="useRoute().path.startsWith('/accounts')"
      class="cursor-pointer flex flex-col justify-center"
      role="button"
      @click="edit"
    >
      <span>
        Edit
      </span>
    </a>
    <a
      class="cursor-pointer flex flex-col justify-center transition-all"
      :class="{'decoration-red-900 hover:decoration-red-600': confirmDelete}"
      role="button"
      @click="softDelete"
    >
      <span
        :class="{'text-red-900 hover:text-red-600': confirmDelete}"
      >
        {{ confirmDelete ? 'Really sure?' : 'Delete' }}
      </span>
    </a>
  </div>
</template>

<style scoped>

</style>
