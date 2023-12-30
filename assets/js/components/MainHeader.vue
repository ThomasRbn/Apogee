<script setup lang="ts">
import axios from "axios";
import {onMounted, ref} from "vue";
import {isJsonEmpty} from "@js/misc/misc.ts";

const user = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get("/api/user/current");
    user.value = response.data;
  } catch (error) {
    console.error("Error fetching user:", error);
  }
});

</script>
<template>
  <header class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #2739ff, #007aff);">
    <div class="container">
      <a href="/" class="navbar-brand">Apogée</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="/" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="/product" class="nav-link">Products</a>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav m-lg-auto">
        <li v-if="isJsonEmpty(user)" class="nav-item">
          <a href="/login" class="nav-link">Log in</a>
        </li>
        <li v-if="isJsonEmpty(user)" class="nav-item">
          <a href="/register" class="nav-link">Sign up</a>
        </li>
        <li v-if="!isJsonEmpty(user)" class="nav-item">
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle bg-transparent border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              My account
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="/user/edit">Edit my profile</a></li>
              <li><a class="dropdown-item text-danger" href="/logout">Log out</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </header>
</template>