<template>
  <nav class="bg-stone-300/80 h-full">
    <ul class="flex flex-col justify-center">
      <li>
        <router-link to="/accounts">
          <i-tabler-credit-card/>
          Accounts
        </router-link>
      </li>
      <li>
        <router-link to="/categories">
          <i-carbon-category-new-each/>
          Categories
        </router-link>
      </li>
      <li>
        <router-link to="/beneficiaries">
          <i-fluent-people-money-20-filled/>
          Beneficiaries
        </router-link>
      </li>
      <li>
        <router-link to="/report">
          <i-clarity-date-outline-alerted/>
          Custom report
        </router-link>
      </li>
      <li>
        <router-link to="/stats">
          <i-carbon-quadrant-plot/>
          Statistics
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
ul > li {
  @apply mx-6 my-4 font-medium tracking-widest text-sm;
}

svg {
  @apply inline text-xl mr-3;
}

.router-link-active {
  @apply text-red-800/70;
}

.router-link-active::before {
  content: '';
  @apply bg-red-800/70 block w-1 h-4 rounded-r-2xl absolute left-0;
}

a {
  @apply transition-all text-black;
}
</style>
