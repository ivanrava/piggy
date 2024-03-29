<template>
  <router-link
    class="flex items-center unstyled transition-all"
    :class="[
      small ? 'rounded-md px-2' : 'rounded-lg p-2',
      textColor,
      isExpired ? 'opacity-30 cursor-not-allowed shadow-sm' : 'cursor-pointer shadow-sm hover:shadow-md']"
    :style="{backgroundColor: `${account.color}`}"
    :to="'/accounts/'+account.id+'/transactions'"
  >
    <Icon
      :icon="account.icon"
      :class="small ? 'text-sm md:text-2xl' : 'text-2xl md:text-4xl'"
    />
    <div class="flex flex-col ml-2 mb-0.5">
      <b
        :class="{'leading-4 md:text-xs xl:text-xs': small}"
        class="whitespace-nowrap text-sm md:text-ssm xl:text-base mb-0.5"
      >{{ account.name }}</b>
      <small
        class="font-light whitespace-nowrap text-xs"
        :class="{'md:text-[8px] leading-[0.8]': small}"
      >{{ account.type }}</small>
    </div>
  </router-link>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {Account} from '../composables/interfaces';
import {computed} from "vue";
import {isColorDark} from "../composables/colors";

const props = withDefaults(defineProps<{
  account: Account,
  small?: boolean
}>(), {
  small: false
})

const textColor = computed(() => {
  return isColorDark(props.account.color.slice(1,7)) ? 'text-slate-950' : 'text-slate-50';
})
const isExpired = computed(() => {
  return new Date(props.account.closing) >= new Date();
})
</script>

<style scoped>
a {
  @apply no-underline;
}
</style>
