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
      </div>
    </section>
    <form-account />
  </div>
</template>

<script setup>
// import AccountRow from "../../components/AccountRow.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import AccountCard from "../../components/AccountCard.vue";
import FormAccount from "../../components/form/crud/AccountForm.vue";

const accounts = ref([]);
const isLoading = ref(false);

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
