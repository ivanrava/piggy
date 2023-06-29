<script setup lang="ts">
import {Account} from "../../composables/interfaces";
import {Icon} from "@iconify/vue";
import {ref} from "vue";
import {useRouter} from "vue-router";

defineProps<{
  accounts: Array<Account>
}>();

const router = useRouter();

const askedForDeletion = ref(null);
const askDelete = (account: Account) => {
  askedForDeletion.value = null;
  setTimeout(() => {
    askedForDeletion.value = account.id;
  }, 500)
}
</script>

<template>
  <div
    v-for="account in accounts"
    :key="account.id"
    class="my-0.5 w-full relative text-stone-900"
    @click="router.push(`/accounts/${account.id}`)"
  >
    <Transition
      mode="out-in"
      name="slide-delete"
    >
      <div
        v-if="askedForDeletion == account.id"
        class="flex items-center px-2 py-1 rounded-sm text-red-900"
      >
        <span class="font-medium text-sm tracking-tighter">Really sure?</span>
        <span
          class="absolute right-6 z-10 px-2 py-1.5 cursor-pointer"
          @click="askedForDeletion = null"
        >
          <Icon icon="carbon:undo" />
        </span>
        <span
          class="absolute right-0 z-10 px-2 py-1.5 cursor-pointer"
          @click="askDelete(account)"
        >
          <Icon icon="fluent:delete-16-regular" />
        </span>
      </div>
      <div
        v-else
        class="flex items-center px-2 py-1 rounded-sm hover:shadow-sm transition-all cursor-pointer"
        :style="{backgroundColor: `#${account.color}11`}"
      >
        <Icon
          :icon="account.icon"
          class="mr-1"
        />
        <span class="text-sm tracking-tighter">{{ account.name }}</span>
        <span class="absolute right-6 z-10 px-2 py-1.5 cursor-pointer opacity-40 hover:opacity-100 transition-all">
          <Icon icon="radix-icons:pencil-1" />
        </span>
        <span
          class="absolute right-0 z-10 px-2 py-1.5 cursor-pointer opacity-40 hover:opacity-100 transition-all"
          @click="askDelete(account)"
        >
          <Icon icon="fluent:delete-16-regular" />
        </span>
      </div>
    </Transition>
  </div>
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
