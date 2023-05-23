<template>
  <router-link
    class="flex items-center shadow-lg cursor-pointer unstyled"
    :class="[small ? 'rounded-md px-2' : 'rounded-lg p-2', textColor]"
    :style="{backgroundColor: `#${account.color}`}"
    :to="'/accounts/'+account.id"
  >
    <Icon :icon="account.icon" :class="small ? 'text-2xl' : 'text-4xl'" />
    <div class="flex flex-col ml-2">
      <b :class="{'leading-4 text-xs': small}">{{ account.name }}</b>
      <small class="font-light" :class="{'text-[8px] leading-[0.8]': small}">{{ account.type }}</small>
    </div>
  </router-link>
</template>

<script setup lang="ts">
import {Icon} from "@iconify/vue";
import {Account} from '../composables/interfaces';
import {useRouter} from "vue-router";
import {computed} from "vue";
const router = useRouter()

const props = withDefaults(defineProps<{
  account: Account,
  small: boolean
}>(), {
  small: false
})

const textColor = computed(() => {
  const brightness = Math.round(((parseInt(props.account.color.slice(0,2), 16) * 299) +
    (parseInt(props.account.color.slice(2,4), 16) * 587) +
    (parseInt(props.account.color.slice(4,6), 16) * 114)) / 1000);

  return brightness > 180 ? 'text-slate-950' : 'text-slate-50';
})
</script>

<style scoped>
a {
  @apply no-underline;
}
</style>
