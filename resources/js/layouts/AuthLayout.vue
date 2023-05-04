<template>
  <main class="flex justify-center items-center bg-pink-50 w-full">
    <div class="w-5/6 h-5/6 bg-stone-50 flex justify-stretch content-stretch gap-24 rounded-lg shadow-2xl">
      <div class="basis-1 grow pl-32 flex flex-col justify-center items-center">
        <img
          alt="Application logo"
          class="w-1/3 mb-16"
          src="/logo-align-left.svg"
        >
        <router-view
          v-slot="{ Component }"
          class="flex text-center h-2/6"
        >
          <transition
            name="slide-fade"
            mode="out-in"
          >
            <component :is="Component" />
          </transition>
        </router-view>
      </div>
      <div class="basis-1 grow flex flex-col justify-center items-center pr-32">
        <img
          src="/vault.svg"
          alt="A drawing of a man putting some money into a vault"
        >
      </div>
    </div>
  </main>
</template>

<script>

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
