<template>
  <div class="flex flex-col w-full bg-pink-50">
    <nav-bar class="h-14 print:hidden" />
    <section class="px-3 pb-3 pt-1.5 grow min-h-0">
      <div class="flex w-full h-full bg-pink-200/50 rounded-3xl shadow-inner">
        <side-bar
          v-if="useRoute().path !== '/home'"
          class="rounded-l-3xl sm:w-2/6 xl:w-1/5 2xl:w-1/6 print:hidden hidden md:block"
        />
        <main
          :class="useRoute().path === '/home' ? 'rounded-l-3xl pl-2' : ''"
          class="w-full bg-stone-200 rounded-r-3xl overflow-scroll print:overflow-visible rounded-l-3xl md:rounded-l-none"
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
