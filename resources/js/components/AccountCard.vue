<template>
  <router-link
    class="flex items-center text-slate-50 drop-shadow-xl cursor-pointer unstyled"
    :class="small ? 'rounded-md px-2' : 'rounded-lg p-2'"
    :style="{backgroundColor: `#${account.color}`}"
    :to="'/accounts/'+account.id"
  >
    <Icon :icon="account.icon" :class="small ? 'text-2xl' : 'text-4xl'" />
    <div class="flex flex-col ml-2">
      <b :class="{'leading-4 text-xs': small}">{{ account.name }}</b>
      <small class="text-stone-100 font-light" :class="{'text-[8px] leading-[0.8]': small}">{{ account.type }}</small>
    </div>
  </router-link>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {Account} from '../composables/interfaces';
import {useRouter} from "vue-router";
const router = useRouter()

withDefaults(defineProps<{
  account: Account,
  small: boolean
}>(), {
  small: false
})

</script>

<style scoped>
a {
  @apply no-underline;
}
</style>
