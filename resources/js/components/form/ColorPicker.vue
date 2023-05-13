<template>
  <div class="my-1 px-3">
    <label-input>Color</label-input>
    <div class="py-0.5 flex justify-center relative">
      <Icon
        id="iconPicker"
        ref="iconPicker"
        icon="tabler:square-rounded-filled"
        class="text-3xl cursor-pointer"
        :style="{color: value}"
        @click="showPicker = !showPicker"
      />
      <Transition name="fade">
        <div
          v-show="showPicker"
          class="absolute z-10 top-12 right-2"
        >
          <Sketch
            v-model="value"
            v-click-outside="closePicker"
            :preset-colors="preset"
          />
        </div>
      </Transition>
    </div>
  </div>
</template>

<script setup lang="ts">
import {Sketch} from "@ckpack/vue-color";
import {computed, ref} from "vue";
import {Icon} from "@iconify/vue";
import LabelInput from "./LabelInput.vue";

const preset = [
  '#111',
  '#181FB5',
  '#184D6F',
  '#4B733D',
  '#28A941',
  '#18ADA2',
  '#B8A500',
  '#DC5235',
  '#d70646',
  '#69182e',
  '#75288c',
  '#e0349e',
  '#D981D3',
  '#7371CF',
  '#7F7F7F',
  '#8D535D',
]

const closePicker = () => {
  if (showPicker.value)
    showPicker.value = false;
}
const iconPicker = ref(null);

const vClickOutside = {
  mounted(el, binding) {
    document.body.addEventListener('click', () => {
      el.__ClickOutsideHandler__ = (event) => {
        let isIconPicker = false;
        if ('nearestViewportElement' in event.target && 'id' in event.target.nearestViewportElement)
          isIconPicker = event.target.nearestViewportElement.id === 'iconPicker';
        if (!(el === event.target || el.contains(event.target) || isIconPicker)) {
          binding.value(event)
        }
      }
      document.body.addEventListener('click', el.__ClickOutsideHandler__)
    })
  },
}

const props = defineProps({
  modelValue: {
    type: String,
  },
  name: {
    type: String,
  },
})
const emit = defineEmits(['update:modelValue'])

const showPicker = ref(false);
const value = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emit('update:modelValue', value['hex'])
  }
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
