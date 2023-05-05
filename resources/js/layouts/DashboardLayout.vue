<template>
  <div class="flex flex-col w-full">
    <nav-bar/>
    <div class="flex w-full h-full">
      <side-bar/>
      <main class="p-4 w-full">
        <router-view
          v-slot="{ Component }"
          class="flex w-full"
        >
          <transition
            name="fade"
            mode="out-in"
          >
            <component :is="Component" />
          </transition>
        </router-view>
      </main>
    </div>
  </div>
</template>

<script>
import {defineComponent} from "vue";
import NavBar from "../components/NavBar.vue";
import SideBar from "../components/SideBar.vue";

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
