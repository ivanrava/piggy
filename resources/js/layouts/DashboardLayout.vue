<template>
  <div class="flex flex-col w-full">
    <nav-bar/>
    <div class="flex w-full h-full">
      <side-bar/>
      <main class="w-full">
        <router-view
          v-slot="{ Component, route }"
          class="flex w-full"
        >
          <transition
            name="fade"
            mode="out-in"
          >
            <div :key="route.name" class="h-full">
              <component :is="Component" />
            </div>
          </transition>
        </router-view>
      </main>
    </div>
  </div>
</template>

<script>
import {defineComponent} from "vue";
import NavBar from "../components/nav/NavBar.vue";
import SideBar from "../components/nav/SideBar.vue";

export default defineComponent({
  components: {SideBar, NavBar}
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
