<template>
  <nav class="h-14 flex justify-between items-center">
    <div class="h-full flex">
      <brand-logo class="h-full p-2.5 cursor-pointer" @click="router.push('home')" />
      <nav class="flex flex-col justify-center">
        <ul class="flex">
          <li v-for="link in links" :key="link.name" class="p-2 relative">
            <router-link
              :to="link.href"
              class="flex flex-col justify-center items-center text-slate-700 opacity-50 hover:opacity-100 transition-all font-medium hover:font-semibold"
            >
              <Icon class="text-2xl" :icon="link.icon" />
              <span class="text-xs">{{ link.name }}</span>
            </router-link>
          </li>
        </ul>
      </nav>
    </div>
    <input class="" />
    <router-link
      class="p-6 !text-lg !text-slate-800 hover:!text-stone-600 tracking-widest font-light uppercase"
      to="/logout"
    >
      Logout
    </router-link>
  </nav>
</template>

<script setup>
import {defineComponent} from "vue";
import BrandLogo from "./BrandLogo.vue";
import {useRouter} from "vue-router";
import {Icon} from "@iconify/vue";

defineComponent({
  components: {BrandLogo}
})

const router = useRouter()

const links = [
  {
    icon: 'tabler:credit-card',
    name: 'Accounts',
    href: '/accounts'
  },
  {
    icon: 'carbon:category-new-each',
    name: 'Categories',
    href: '/categories'
  },
  {
    icon: 'fluent:people-money-20-filled',
    name: 'Beneficiaries',
    href: '/beneficiaries'
  },
  {
    icon: 'clarity:date-outline-alerted',
    name: 'Reporting',
    href: '/report'
  },
  {
    icon: 'carbon:quadrant-plot',
    name: 'Statistics',
    href: '/stats'
  }
]
</script>

<style scoped>
.router-link-active {
  @apply opacity-100 font-semibold;
}

.router-link-active::before {
  content: '';
  @apply bg-slate-900 block w-6 h-1 rounded-lg absolute bottom-0.5;
}
</style>
