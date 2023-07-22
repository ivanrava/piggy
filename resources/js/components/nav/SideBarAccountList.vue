<script setup lang="ts">
import {Account} from "../../composables/interfaces";
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import {isColorDark} from "../../composables/colors";
import axios from "axios";
import {useAccountsStore} from "../../composables/useAccountsStore";
import EmptyListMessage from "../EmptyListMessage.vue";

defineProps<{
  accounts: Array<Account>
}>();

const router = useRouter();
const store = useAccountsStore();

const askedForDeletion = ref(null);
const askDelete = (account: Account) => {
  // askedForDeletion.value = null;
  askedForDeletion.value = account.id;
}
const isSelected = (account: Account) => {
  return useRoute().params.id == account.id;
}
const textColor = (account: Account) => {
  return isColorDark(account.color.slice(1,7)) ? 'text-slate-950' : 'text-slate-50';
}
const trueDelete = (account: Account) => {
  axios.delete(`/accounts/${account.id}`)
    .then(() => {
      store.deleteAccount(account)
    })
    .catch((res) => {
      console.log(res)
    })
}
</script>

<template>
  <div
    v-for="account in accounts"
    :key="account.id"
    class="my-0.5 w-full text-stone-900"
  >
    <Transition
      mode="out-in"
      name="slide-delete"
    >
      <div
        v-if="askedForDeletion == account.id"
        class="flex justify-between items-center py-1 rounded-sm text-red-900"
      >
        <span class="font-medium text-sm tracking-tighter flex-grow pl-2">Really sure?</span>
        <aside class="flex justify-end items-center gap-2 px-2">
          <span
            class="cursor-pointer"
            @click="askedForDeletion = null"
          >
            <Icon icon="carbon:undo" />
          </span>
          <span
            class="cursor-pointer"
            @click="trueDelete(account)"
          >
            <Icon icon="fluent:delete-16-regular" />
          </span>
        </aside>
      </div>
      <div
        v-else
        class="flex"
      >
        <div
          class="flex items-center px-2 py-1 rounded-md hover:shadow-sm transition-all cursor-pointer flex-grow"
          :class="{'shadow-sm': isSelected(account)}"
          :style="{backgroundColor: `${account.color}${ isSelected(account) ? 'ff' : '11'}`}"
          @click="router.push(`/accounts/${account.id}`)"
        >
          <Icon
            :icon="account.icon"
            class="mr-1"
            :class="{[textColor(account)]: isSelected(account)}"
          />
          <span
            class="text-sm tracking-tighter"
            :class="{'font-semibold' : isSelected(account), [textColor(account)]: isSelected(account)}"
          >
            {{ account.name }}
          </span>
        </div>
        <aside
          v-if="!isSelected(account)"
          class="flex justify-end items-center gap-2 px-2"
        >
          <span
            class="cursor-pointer opacity-40 hover:opacity-100 transition-all"
            @click="askDelete(account)"
          >
            <Icon icon="fluent:delete-16-regular" />
          </span>
        </aside>
      </div>
    </Transition>
  </div>
  <EmptyListMessage v-if="accounts.length == 0">
    Still no accounts here...
  </EmptyListMessage>
</template>

<style scoped>
.slide-delete-enter-active {
  transition: all 0.4s cubic-bezier(.62,.16,.13,1.01);
}

.slide-delete-leave-active {
  transition: all 0.4s cubic-bezier(.62,.16,.13,1.01);
}

.slide-delete-enter-from {
  transform: translateX(120%);
}
.slide-delete-enter-to {
  opacity: 100%;
}
.slide-delete-leave-to {
  opacity: 0;
}
</style>
