<template>
  <!--  <table class="table">-->
  <!--    <thead>-->
  <!--      <tr class="text-xl border-b-2">-->
  <!--        <th class="text-left">-->
  <!--          Account-->
  <!--        </th>-->
  <!--        <th class="text-right">-->
  <!--          Balance-->
  <!--        </th>-->
  <!--      </tr>-->
  <!--    </thead>-->
  <!--    <tbody>-->
  <!--      <account-row-->
  <!--        v-for="account in accounts"-->
  <!--        :key="account.name"-->
  <!--        :account="account"-->
  <!--      />-->
  <!--    </tbody>-->
  <!--  </table>-->
  <div class="flex flex-col justify-between h-full">
    <section class="p-4">
      <h1>Accounts</h1>
      <div class="flex flex-wrap gap-4">
        <account-card
          v-for="account in accounts"
          :key="account"
          :account="account"
        />
        <account-card
          :account="accountAdd"
          class="opacity-20 text-slate-900 border-2 border-slate-900 border-dashed hover:opacity-60 transition-all"
          :class="{'opacity-70': showForm}"
          @click="showForm = !showForm"
        />
      </div>
    </section>
    <section class="px-8">
      <form-account
        class="relative top-full transition-all p-4 shadow-xl shadow-gray-400 rounded-t-3xl bg-stone-50"
        :class="{'top-0': showForm}"
      />
    </section>
  </div>
</template>

<script setup>
// import AccountRow from "../../components/AccountRow.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import AccountCard from "../../components/AccountCard.vue";
import FormAccount from "../../components/FormAccount.vue";

const accounts = ref([]);
const isLoading = ref(false);
const accountAdd = ref({
  name: 'Add a new account',
  type: '',
  color: 'fff',
  icon: 'material-symbols:add-card-rounded'
});
const showForm = ref(false);

onMounted(async () => {
  isLoading.value = true;
  try {
    const res = axios.get('/accounts');
    accounts.value = (await res).data.data;
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
  isLoading.value = false;
})
</script>

<style scoped>
th {
  @apply p-2;
}
</style>
