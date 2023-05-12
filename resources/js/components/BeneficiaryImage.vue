<script setup lang="ts">
import {computed} from "vue";
import {bottts, botttsNeutral, initials, loreleiNeutral, notionistsNeutral, shapes, thumbs} from "@dicebear/collection";
import {createAvatar} from "@dicebear/core";

const props = defineProps({
  beneficiary: Object
})

const allStyles = {
  'bottts': bottts,
  'botttsNeutral': botttsNeutral,
  'loreleiNeutral': loreleiNeutral,
  'notionistsNeutral': notionistsNeutral,
  'thumbs': thumbs,
  'shapes': shapes,
  'initials': initials
}

const fallbackAvatar = (name) => {
  return createAvatar(initials, {
    seed: name,
    flip: false,
    rotate: 0,
    scale: 70,
    radius: 0,
    size: 96,
    backgroundColor: ["b6e3f4","c0aede","d1d4f9","ffd5dc","ffdfbf"]
  }).toDataUriSync()
}

const imageSrc = computed(() => {
  if (props.beneficiary.img.startsWith('https://'))
    return props.beneficiary.img

  return createAvatar(allStyles[props.beneficiary.img], {
    seed: props.beneficiary.name,
    flip: false,
    rotate: 0,
    scale: 70,
    radius: 0,
    size: 96,
    backgroundColor: ["b6e3f4","c0aede","d1d4f9","ffd5dc","ffdfbf"]
  }).toDataUriSync();
})
</script>

<template>
  <img
    :src="imageSrc"
    class="w-16 h-16 rounded-xl p-2"
    alt=""
    @error="$event.target.src = fallbackAvatar(beneficiary.name)"
  />
</template>

<style scoped>

</style>
