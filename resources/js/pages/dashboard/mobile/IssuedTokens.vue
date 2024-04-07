<script setup lang="ts">

</script>

<template>
  <section class="w-full">
    <h2>Logged devices</h2>
    <p>
      Here you can see every device which has been logged to your account through
      the companion app.
      You can also revoke access to your account, if you want.
    </p>
    <table class="my-2 w-full text-left">
      <tr>
        <th>Device name</th>
        <th class="text-right">Actions</th>
      </tr>
      <tr>
        <td>Example</td>
        <td class="text-right">Example</td>
      </tr>
    </table>
  </section>
</template>

<style scoped>
th, td {
  @apply py-1
}
th {
  @apply border-b-[1px] border-pink-50 text-xl
}
</style>
