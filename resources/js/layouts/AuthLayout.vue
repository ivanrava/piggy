<template>
  <main class="flex justify-center items-center bg-pink-200 w-full dark:bg-pink-950">
    <div class="w-5/6 h-5/6 bg-stone-50 dark:bg-stone-900 flex justify-stretch content-stretch rounded-lg shadow-2xl dark:text-stone-300">
      <div class="basis-1 grow pl-0 xl:pl-8 2xl:pl-16 flex flex-col justify-center items-center">
        <img
          alt="Application logo"
          src="/logo-align-left.svg"
          class="w-2/5 md:w-1/3 xl:w-1/3 mt-32 dark:invert"
        >
        <router-view
          v-slot="{ Component }"
          class="flex text-center h-2/3 w-2/3 md:w-1/2 2xl:w-2/5"
        >
          <transition
            name="slide-fade"
            mode="out-in"
          >
            <component :is="Component" />
          </transition>
        </router-view>
      </div>
      <div class="basis-1 grow lg:flex flex-col justify-center items-center pr-16 lg:pr-32 hidden">
        <Transition
          name="slide-fade"
          mode="out-in"
        >
          <img
            v-if="imgIdx == 0"
            class="h-2/3"
            src="/vault.svg"
            alt="A drawing of a man putting some money into a vault"
          >
          <img
            v-else-if="imgIdx == 1"
            class="h-2/3"
            src="/invest.svg"
            alt="A drawing of a man putting some money into a vault"
          >
          <img
            v-else-if="imgIdx == 2"
            class="h-2/3"
            src="/transactions.svg"
            alt="A drawing of a man putting some money into a vault"
          >
        </Transition>
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import {ref} from "vue";

const imgIdx = ref(0);
const imgIdxMax = 2;
setInterval(() => {
  if (imgIdx.value == imgIdxMax)
    imgIdx.value = 0;
  else
    imgIdx.value += 1;
}, 5000)
</script>

<style scoped lang="scss">
$slide_amount: 40px;
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.4s ease-out;
}

.slide-fade-enter-from {
  transform: translateX(-$slide_amount);
  opacity: 0;
}

.slide-fade-leave-to {
  transform: translateX($slide_amount);
  opacity: 0;
}
</style>
