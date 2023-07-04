<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionDataTable from "../../../components/TransactionDataTable.vue";
import {useOperationsStore} from "../../../composables/useOperationsStore";
import {Category} from "../../../composables/interfaces";
import {Icon} from "@iconify/vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";

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
      <div class="h-6 bg-gray-400 rounded-md w-96 mb-4 my-3 animate-pulse" />
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse" />
    </div>
    <div
      v-else
      class="flex justify-between"
    >
      <div
        class="flex flex-col my-4"
      >
        <router-link
          :to="`/categories/${category.id}`"
          class="unstyled uppercase tracking-wider text-stone-800/50 hover:text-pink-800/90 focus:font-medium transition-all flex gap-2 items-center"
        >
          <Icon icon="pajamas:go-back" />
          Back to the category details
        </router-link>
        <h1 class="my-1">
          Transactions under {{ category.name }}
        </h1>
      </div>
      <div class="flex gap-4">
        <div class="flex flex-col justify-center items-end">
          <div
            class="py-2 px-3 text-stone-50 rounded-xl flex items-center gap-3 shadow-sm"
            :class="category.type === 'out' ? 'bg-red-500/90' : 'bg-green-500/90'"
          >
            <div class="flex flex-col items-end">
              <h2 class="font-bold my-0 text-xl">
                <Icon
                  :icon="category.icon"
                  class="inline"
                /> {{ category.name }}
              </h2>
              <small class="font-light">{{ category.type === 'out' ? 'Expense' : 'Income' }}</small>
            </div>
            <span class="text-4xl tracking-tighter font-light">
              {{ useAgGridUtilites().currencyFormatterBare(store.getTotal()) }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </Transition>
  <transaction-data-table :fields="['account', 'beneficiary']" />
</template>

<style scoped>

</style>
