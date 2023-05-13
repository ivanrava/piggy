<template>
  <div class="px-3">
    <label-input>Color</label-input>
    <div class="py-2 flex justify-center relative">
      <Icon
        id="iconPicker"
        ref="iconPicker"
        icon="material-symbols:circle"
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
        if ('nearestViewportElement' in event.target && 'id' in event.target)
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
