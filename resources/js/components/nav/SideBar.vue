<template>
  <nav class="bg-pink-100/20 w-1/6 h-full">
    <ul>
      <li>
        Data tracking
        <ul>
          <li>
            <router-link to="/accounts"><i-tabler-credit-card /> Accounts</router-link>
          </li>
          <li>
            <router-link to="/categories"><i-carbon-category-new-each /> Categories</router-link>
          </li>
          <li>
            <router-link to="/beneficiaries"><i-fluent-people-money-20-filled /> Beneficiaries</router-link>
          </li>
        </ul>
      </li>
      <li>
        Reporting
        <ul>
          <li>
            <router-link to="/report"><i-clarity-date-outline-alerted /> Custom report</router-link>
          </li>
          <li>
            <router-link to="/stats"><i-carbon-quadrant-plot /> Statistics</router-link>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
ul > li {
  @apply m-3 uppercase font-bold tracking-wide text-red-950;
}
ul > li > ul > li {
  @apply m-3 capitalize font-medium text-sm text-stone-500 hover:text-stone-950 transition-all tracking-widest;
}
svg {
  @apply inline;
}
</style>
