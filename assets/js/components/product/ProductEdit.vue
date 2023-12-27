<script setup lang="ts">
import ProductForm from '@js/components/product/ProductForm.vue';
import {PropType} from "vue";
import {Product} from "@js/types/types.ts";

const props = defineProps({
  product: {
    type: Object as PropType<Product>,
    required: true,
  },
});
</script>

<template>
  <div class="container mt-4">
    <h1>Edit a product</h1>
    <ProductForm :product="props.product" button-text="Update product"/>
  </div>
</template>