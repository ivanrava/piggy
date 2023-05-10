<script setup lang="ts">
import FormInput from "./FormInput.vue";
import {computed, ref} from "vue";
import {hashCode} from "../../composables/hash";

const name = ref('');

const previewLogo = computed(() => {
  return `https://logo.clearbit.com/${name.value}.it`
})

const loadFallback = (event) => {
  event.target.src=`https://placehold.co/256x256/${hashCode(name.value)}/white?font=lato&text=${name.value}`
}
</script>

<template>
  <h2>Add a new beneficiary</h2>
  <form class="flex flex-row h-24 gap-4">
    <img
      :src="previewLogo"
      alt="Image preview for new beneficiary"
      class="rounded-xl"
      @error="loadFallback($event)"
    />
    <aside>
      <form-input placeholder="Name" v-model="name" />
      <div>
        <input type="radio" id="person">
        <label class="mx-1" for="person">Person</label>
        <input type="radio" id="company">
        <label class="mx-1" for="company">Company</label>
        <input type="radio" id="other">
        <label class="mx-1" for="other">Other</label>
      </div>
    </aside>
  </form>
</template>

<style scoped>

</style>
