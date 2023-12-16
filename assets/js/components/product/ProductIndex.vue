<script setup lang="ts">

interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
}

defineProps({
  products: {
    type: Array<Product>,
    required: true
  }
})

</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Product Index</h1>
        <table class="table table-bordered">
          <thead>
          <tr>
            <th scope="col">ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>