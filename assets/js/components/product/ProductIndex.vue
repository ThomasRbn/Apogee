<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";
import Pagination from "../misc/Pagination.vue";

interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
}

const products = ref<Array<Product>>([]);
const lastPage = ref<number>(0);


onMounted(async () => {
  try {
    const response = await axios.get("/api/product");
    products.value = response.data['products'];
    lastPage.value = Math.ceil(response.data['count'] / 10);
  } catch (error) {
    console.error("Error fetching products:", error);
  }
});

function onChangePage(limit: number, page: number) {
  axios.get(`/api/product?limit=${limit}&page=${page}`)
      .then(response => {
        products.value = response.data['products'];
      })
      .catch(error => console.error("Error fetching products:", error));
}

</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-4">
        <h1>Product Index</h1>
        <table class="table table-bordered mt-4">
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
        <Pagination :on-change-page="onChangePage" :last-page="lastPage" :current-page="1" :per-page="10"></Pagination>
      </div>
    </div>
  </div>
</template>