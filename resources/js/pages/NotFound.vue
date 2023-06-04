<script setup lang="ts">

</script>

<template>
  <main class="flex flex-col justify-center items-center w-full bg-pink-100/30">
    <div class="w-3/4 h-2/3 drop-shadow-xl bg-stone-50/80 rounded-xl flex flex-col">
      <header class="bg-pink-100/60 p-8 rounded-t-xl">
        <img
          alt="Piggy logo"
          class="h-16"
          src="/logo-align-left.svg"
        >
      </header>
      <section class="p-16">
        <h1 class="text-[48px] font-normal">
          Uh, oh.
        </h1>
        <p class="mt-8">
          The page you requested could not be found. It might have been removed or had its name changed.
        </p>
        <p class="mt-4">
          If you think something is broken, please report the problem to us.
        </p>
        <p class="mt-2">
          <router-link to="/">
            Go back to the main page
          </router-link>
        </p>
      </section>
      <footer class="font-bold uppercase tracking-widest opacity-40 absolute right-8 bottom-6">
        404 : Page Not Found
      </footer>
    </div>
  </main>
</template>

<style scoped>

</style>
