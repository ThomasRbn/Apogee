<script setup lang="ts">

import {ref} from "vue";
import axios from "axios";
import Swal from "sweetalert2";

const formData = ref({
  email: '',
  plainPassword: '',
});

const submitForm = () => {
  axios.post('/api/user/login', formData.value)
      .then((response) => {
        console.log(response);
        Swal.fire({
          icon: 'success',
          title: `Nice to see you ${response.data}!\nRedirecting to home page...`,
          showConfirmButton: false,
          timer: 2500,
        }).then(() => {
          window.location.href = '/';
        });
      })
      .catch((error) => {
        Swal.fire({
          icon: 'error',
          title: 'Something went wrong!',
          text: error.response.data,
        });
      });
};

</script>

<template>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h1 class="mb-4">Log in to Apogée</h1>
        <form @submit.prevent="submitForm">
          <div class="form-group form-floating mb-3">
            <input v-model="formData.email" type="email" class="form-control" id="email" placeholder="Email">
            <label for="email">Email</label>
          </div>
          <div class="form-group form-floating mb-3">
            <input v-model="formData.plainPassword" type="password" class="form-control" id="plainPassword"
                   placeholder="Password">
            <label for="plainPassword">Password</label>
          </div>
          <button type="submit" class="btn btn-primary">Log in</button>
        </form>
      </div>
    </div>
  </div>
</template>