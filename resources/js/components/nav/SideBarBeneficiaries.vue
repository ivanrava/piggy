<script setup lang="ts">
import BeneficiaryCard from "../BeneficiaryCard.vue";
import {useBeneficiariesStore} from "../../composables/useBeneficiariesStore";
import {useRoute} from "vue-router";
import {Beneficiary} from "../../composables/interfaces";
import {onMounted, ref} from "vue";
import axios from "axios";
import {Icon} from "@iconify/vue";
import BeneficiaryImage from "../BeneficiaryImage.vue";

const store = useBeneficiariesStore();

const opacityClass = (beneficiary: Beneficiary) => {
  if (useRoute().path.endsWith('beneficiaries')) {
    return 'opacity-60'
  } else {
    return beneficiary.id == Number(useRoute().params.id) ? 'opacity-100' : 'opacity-40'
  }
}

onMounted(async () => {
  if (store.beneficiaries.length > 0)
    return

  try {
    const res = axios.get('/beneficiaries');
    store.setBeneficiaries((await res).data.data);
  } catch (error) {
    console.log('Error! Could not reach the API. ' + error)
  }
})

const askedForDeletion = ref(null);
const askDelete = (beneficiary: Beneficiary) => {
  if (askedForDeletion.value == null) {
    askedForDeletion.value = beneficiary.id;
    return
  }

  axios.delete(`/beneficiaries/${beneficiary.id}`)
    .then(() => {
      store.deleteBeneficiary(beneficiary)
    })
    .catch((res) => {
      console.log(res)
    })
}
</script>

<template>
  <section>
    <div
      v-for="beneficiary in store.beneficiaries"
      :key="beneficiary.id"
      class="flex flex-row items-center justify-between"
    >
      <Transition
        mode="out-in"
        name="fade"
      >
        <beneficiary-card
          v-if="askedForDeletion != beneficiary.id"
          :beneficiary="beneficiary"
          :hide-bg="true"
          :small="true"
          class="hover:opacity-100"
          :class="opacityClass(beneficiary)"
        />
        <div
          v-else
          class="flex flex-row items-center grow"
        >
          <BeneficiaryImage
            class="!h-12 !w-12 blur-sm"
            :beneficiary="beneficiary"
          />
          <span class="grow text-sm font-medium text-red-900">
            Confirm deletion?
          </span>
          <div
            v-if="askedForDeletion == beneficiary.id"
            class="pl-4 text-lg opacity-50 cursor-pointer hover:opacity-100 transition-all"
            @click="askedForDeletion = null"
          >
            <Icon icon="carbon:undo" />
          </div>
        </div>
      </Transition>
      <div
        class="px-4 text-lg opacity-50 cursor-pointer hover:opacity-100 transition-all"
        :class="{'text-red-900 !opacity-90 hover:!opacity-100':askedForDeletion == beneficiary.id}"
        @click="askDelete(beneficiary)"
      >
        <Icon icon="fluent:delete-16-regular" />
      </div>
    </div>
  </section>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
