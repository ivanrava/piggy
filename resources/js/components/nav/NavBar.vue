<template>
  <nav class="flex justify-between items-center">
    <div class="h-full flex">
      <brand-logo />
      <nav class="flex flex-col justify-center">
        <ul class="flex md:gap-0">
          <li
            v-for="link in links"
            :key="link.name"
            class="p-2 relative md:w-20"
          >
            <router-link
              :to="link.href"
              class="flex flex-col justify-center items-center text-slate-800/90 dark:text-stone-300 opacity-50 hover:opacity-100 transition-all font-medium hover:font-semibold"
              :class="{'router-link-active': useRoute().path.startsWith(link.href)}"
            >
              <Icon
                class="text-2xl"
                :icon="link.icon"
              />
              <span class="hidden md:block text-xs">{{ link.name }}</span>
            </router-link>
          </li>
        </ul>
      </nav>
    </div>
    <search-bar class="hidden" />
    <router-link
      class="p-6 !text-lg !text-slate-800 dark:!text-stone-100 hover:!text-stone-600 dark:hover:!text-stone-300 md:tracking-widest md:font-light font-normal uppercase"
      to="/logout"
    >
      Logout
    </router-link>
  </nav>
</template>

<script setup>
import {defineComponent} from "vue";
import BrandLogo from "./BrandLogo.vue";
import {useRoute} from "vue-router";
import {Icon} from "@iconify/vue";
import SearchBar from "./SearchBar.vue";

defineComponent({
  components: {BrandLogo}
})

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
    icon: 'mdi:property-tag',
    name: 'Properties',
    href: '/properties'
  },
  {
    icon: 'teenyicons:table-solid',
    name: 'Reporting',
    href: '/report'
  },
  {
    icon: 'fluent:data-pie-20-filled',
    name: 'Charts',
    href: '/charts'
  }
]
</script>

<style scoped>
.router-link-active {
  @apply opacity-100 font-semibold;
}

.router-link-active::before {
  content: '';
  @apply bg-slate-900 dark:bg-stone-200 block w-4 md:w-6 h-1 rounded-lg absolute bottom-0.5;
}
</style>
