<script setup lang="ts">
import {ref} from "vue";

const props = defineProps({
  onSubmit: {
    type: Function,
    required: true,
  }
})

const count = ref(0);

const increaseCounter = () => {
  count.value++;
}

const decreaseCounter = () => {
  if (count.value === 0) return;
  count.value--;
}

</script>

<template>

  <div class="d-flex flex-row gap-3 mb-3">
    <button class="btn btn-danger flex-grow-1" @click="decreaseCounter">-</button>
    <input class="text-center" v-model="count" type="number" min="0" disabled>
    <button class="btn btn-success flex-grow-1" @click="increaseCounter">+</button>
  </div>
  <button class="btn btn-success" @click="props.onSubmit(count)">Add to cart</button>

</template>