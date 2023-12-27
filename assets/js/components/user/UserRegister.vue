<template>
  <div class="container mt-4">
    <h1 class="mb-4">Welcome to Apogée, your future is starting now</h1>
    <UserForm :button-text="String('Register')"/>
  </div>
</template>

<script setup lang="ts">
import UserForm from "./UserForm.vue";
</script>