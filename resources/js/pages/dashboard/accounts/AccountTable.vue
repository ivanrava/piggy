<script setup lang="ts">
import {onMounted, ref} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";
import TransactionForm from "../../../components/form/crud/TransactionForm.vue";
import {Account} from "../../../composables/interfaces";
import TransactionDataTable from "../../../components/TransactionDataTable.vue";
import {useOperationsStore} from "../../../composables/useOperationsStore";
import {Icon} from "@iconify/vue";
import {useAgGridUtilites} from "../../../composables/useAgGridUtilities";
import {computed} from "vue";
import {isColorDark} from "../../../composables/colors";

const route = useRoute();
const store = useOperationsStore();

const account = ref<Account>(null);
const errors = ref([]);
onMounted(() => {
  axios.get(`/accounts/${route.params.id}`).then(({data}) => {
    account.value = data.data;
    store.setOperations(
      account.value.transactions,
      account.value.in_transfers,
      account.value.out_transfers
    );
  }).catch(({response}) => {
    errors.value = response.data.errors;
  })
});

const textColor = computed(() => {
  return isColorDark(account.value.color.slice(1,7)) ? 'text-slate-950' : 'text-slate-50';
})
</script>

<template>
  <Transition
    name="fade-loading"
    mode="out-in"
  >
    <div v-if="account == null">
      <div class="h-6 bg-gray-400 rounded-md w-96 mb-4 my-3 animate-pulse" />
      <div class="h-10 bg-gray-400 rounded-md w-96 mb-4 my-4 animate-pulse" />
    </div>
    <div
      v-else
      class="flex justify-between"
    >
      <div>
        <div
          class="flex flex-col my-4"
        >
          <router-link
            :to="`/accounts/${account.id}`"
            class="unstyled uppercase tracking-wider text-stone-800/50 hover:text-pink-800/90 focus:font-medium transition-all flex gap-2 items-center"
          >
            <Icon icon="pajamas:go-back" />
            Back to the account details
          </router-link>
          <h1 class="my-1">
            Transactions under {{ account.name }}
          </h1>
        </div>
      </div>
      <div
        class="flex flex-col justify-center gap-4 ml-4"
        :class="textColor"
      >
        <div
          class="flex py-2 px-3 rounded-lg shadow-sm items-center gap-4"
          :style="{backgroundColor: account.color}"
        >
          <div class="flex flex-col justify-center items-end my-1">
            <h2 class="font-bold whitespace-nowrap text-lg my-0">
              <Icon
                :icon="account.icon"
                class="inline text-2xl"
              />
              {{ account.name }}
            </h2>
            <small class="font-extralight whitespace-nowrap">{{ account.type }}</small>
          </div>
          <span class="text-4xl font-light whitespace-nowrap tracking-tighter">
            {{ useAgGridUtilites().currencyFormatterBare(store.getTotal()) }}
          </span>
        </div>
      </div>
    </div>
  </Transition>
  <transaction-data-table :fields="['beneficiary', 'category']" />
  <transaction-form
    v-if="account"
    :account-id="account.id"
  />
</template>

<style>
</style>
