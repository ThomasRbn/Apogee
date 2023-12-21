<script setup lang="ts">
import {computed, PropType, reactive, ref} from 'vue';
import {useVuelidate} from '@vuelidate/core';
import {maxLength, minLength, minValue, required} from '@vuelidate/validators';
import axios from "axios";
import Swal from 'sweetalert2';

interface Product {
  id: number;
  name: string;
  price: number;
  description: string;
}

const props = defineProps({
  product: {
    type: Object as PropType<Product>,
    required: false,
  },
  buttonText: {
    type: String,
    required: false,
    default: 'Create Product',
  },
});

const formData = ref<Product>({
  id: props.product ? props.product.id : null,
  name: props.product ? props.product.name : null,
  price: props.product ? props.product.price : null,
  description: props.product ? props.product.description : null,
});

const rules = computed(() => {
  return {
    name: {
      required,
      minLength: minLength(3),
      maxLength: maxLength(255),
    },
    price: {
      required,
      type: Number,
      minValue: minValue(0.01),
    },
    description: {
      required,
      minLength: minLength(3),
    },
  };
});

const v$ = useVuelidate(rules, formData);

const createProduct = async () => {
  const result = await v$.value.$validate();
  if (!result) {
    return;
  }

  axios.post('/api/product', formData.value)
      .then((response) => {
        if (formData.value.id) {
          Swal.fire(
              'Product updated!',
              'The product has been updated successfully.',
              'info'
          ).then(() => {
            window.location.href = '/product'
          });
          return;
        } else {
          Swal.fire(
              'Product created!',
              'The product has been created successfully.',
              'success'
          ).then(() => {
            window.location.href = '/product'
          });
        }
      })
      .catch((error) => {
        console.log(error);
      });
};
</script>

<template>
  <div class="container mt-5">
    <!--    <div v-if="productCreated" class="mt-3">-->
    <!--      <h2>Product created successfully!</h2>-->
    <!--      <p>Name: {{ formData.name }}</p>-->
    <!--      <p>Price: {{ formData.price }}</p>-->
    <!--      <p>Description: {{ formData.description }}</p>-->
    <!--    </div>-->

    <form @submit.prevent="createProduct" class="mb-3">
      <div class="mb-3">
        <label for="productName" class="form-label">Product Name:</label>
        <input
            type="text"
            id="productName"
            class="form-control"
            v-model="formData.name"
        />
        <span v-for="error in v$.name.$errors" :key="error.$uid" class="text-danger">{{ error.$message }}</span>
      </div>

      <div class="mb-3">
        <label for="productPrice" class="form-label">Price:</label>
        <input
            id="productPrice"
            class="form-control"
            v-model="formData.price"
        />
        <span v-for="error in v$.price.$errors" :key="error.$uid" class="text-danger">{{ error.$message }}</span>
      </div>

      <div class="mb-3">
        <label for="productDescription" class="form-label">Description:</label>
        <textarea
            id="productDescription"
            class="form-control"
            v-model="formData.description"
        ></textarea>
        <span v-for="error in v$.description.$errors" :key="error.$uid" class="text-danger">{{ error.$message }}</span>
      </div>

      <button type="submit" class="btn btn-primary">{{ props.buttonText }}</button>
    </form>
  </div>
</template>