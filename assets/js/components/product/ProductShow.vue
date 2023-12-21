<template>
  <div class="d-flex flex-column justify-content-center align-content-center product-details mt-5">
    <h1>{{ product.name }}</h1>
    <p>{{ product.description }}</p>
    <p><strong>Price:</strong> ${{ product.price.toFixed(2) }}</p>
  </div>
</template>

<script setup lang="ts">
import { PropType } from "vue";

interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
}

defineProps({
  product: {
    type: Object as PropType<Product>,
    required: true,
  },
});
</script>

<style scoped>
/* Ajoutez vos styles spécifiques au composant ici */
.product-details {
  max-width: 400px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
