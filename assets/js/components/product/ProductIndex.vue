<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";
import Pagination from "@js/components/misc/Pagination.vue";
import {Product} from "@js/types/types.ts";

const products = ref<Array<Product>>([]);
const lastPage = ref<number>(0);
const currentPage = ref<number>(1);

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
  currentPage.value = page;
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
        <a href="/product/new" class="btn btn-success">Create Product</a>
        <table class="table table-bordered mt-4">
          <thead>
          <tr>
            <th scope="col">ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td>
              <a :href="`/product/${product.id}`" class="btn btn-primary">Show</a>
              <a :href="`/product/edit/${product.id}`" class="btn btn-warning">Edit</a>
              <a :href="`/product/delete/${product.id}`" class="btn btn-danger">Delete</a>
            </td>
          </tr>
          </tbody>
        </table>
        <Pagination :on-change-page="onChangePage" :last-page="lastPage" :current-page="currentPage"
                    :per-page="10"></Pagination>
      </div>
    </div>
  </div>
</template>