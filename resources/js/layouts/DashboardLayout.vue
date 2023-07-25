<template>
  <div class="flex flex-col w-full bg-pink-200/90 dark:bg-pink-950">
    <nav-bar class="h-14 print:hidden" />
    <section class="px-3 pb-3 pt-1.5 grow min-h-0">
      <div class="flex w-full h-full bg-pink-200/50 rounded-3xl shadow-inner">
        <side-bar
          v-if="useRoute().path !== '/home'"
          class="rounded-l-3xl sm:w-1/2 lg:w-2/5 2xl:w-1/4 print:hidden hidden md:block"
        />
        <main
          :class="useRoute().path === '/home' ? 'md:rounded-l-3xl pl-2' : 'md:rounded-l-none'"
          class="w-full bg-stone-200 dark:bg-stone-900/80 dark:text-stone-200 rounded-r-3xl overflow-scroll print:overflow-visible rounded-l-3xl"
        >
          <router-view
            v-slot="{ Component, route }"
            class="flex w-full"
          >
            <transition
              name="fade"
              mode="out-in"
            >
              <div
                :key="route.fullPath"
                class="h-full p-4"
              >
                <component :is="Component" />
              </div>
            </transition>
          </router-view>
        </main>
      </div>
    </section>
  </div>
</template>

<script>
import {defineComponent} from "vue";
import NavBar from "../components/nav/NavBar.vue";
import SideBar from "../components/nav/SideBar.vue";
import {useRoute} from "vue-router";

export default defineComponent({
  components: {SideBar, NavBar},
  methods: {useRoute}
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
