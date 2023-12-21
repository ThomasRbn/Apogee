<script setup lang="ts">
import ProductForm from './ProductForm.vue';
import {PropType} from "vue";

interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
}

const props = defineProps({
  product: {
    type: Object as PropType<Product>,
    required: true,
  },
});
</script>

<template>
  <h1>Edit a product</h1>
  <ProductForm :product="props.product"/>
</template>