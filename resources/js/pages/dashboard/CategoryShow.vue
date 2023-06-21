<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionDataTable from "../../components/TransactionDataTable.vue";
import {useOperationsStore} from "../../composables/useOperationsStore";
import {Category} from "../../composables/interfaces";

const category = ref<Category>(null);
const store = useOperationsStore();

const errors = ref({});
onMounted(() => {
  store.setOperations([], [], []);
  axios.get("/categories/"+useRoute().params.id).then(({data}) => {
    category.value = data.data;
    store.setOperations(category.value.transactions, [], [])
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});
</script>

<template>
  <Transition
    name="fade-loading"
    mode="out-in"
  >
    <div v-if="category == null">
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse" />
    </div>
    <h1 v-else>
      Transactions under {{ category.name }}
    </h1>
  </Transition>
  <transaction-data-table :fields="['account', 'beneficiary']" />
</template>

<style scoped>

</style>
