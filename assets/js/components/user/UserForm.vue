<script setup lang="ts">

import {computed, PropType, ref} from "vue";
import {email, helpers, maxLength, minLength, required, sameAs} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";
import axios from "axios";
import {User} from "@js/types/types.ts";
import Swal from "sweetalert2";

const props = defineProps({
  user: {
    type: Object as PropType<User>,
    required: false,
  },
  buttonText: {
    type: String,
    required: true,
  },
});

const confirmPlainPassword = ref<string>(null);
const formErrors = computed(() => ({
  email: !!v$.value.email.$error,
  firstName: !!v$.value.firstName.$error,
  lastName: !!v$.value.lastName.$error,
  address: !!v$.value.address.$error,
  city: !!v$.value.city.$error,
  zipcode: !!v$.value.zipcode.$error,
  plainPassword: !!v$.value.plainPassword.$error,
}));

const formOK = computed(() => ({
  email: !v$.value.email.$invalid,
  firstName: !v$.value.firstName.$invalid,
  lastName: !v$.value.lastName.$invalid,
  address: !v$.value.address.$invalid,
  city: !v$.value.city.$invalid,
  zipcode: !v$.value.zipcode.$invalid,
  plainPassword: !v$.value.plainPassword.$invalid,
}));

const rules = computed(() => {
  return {
    email: {
      required: helpers.withMessage('Email is required', required),
      email: helpers.withMessage('Email must be valid', email),
    },
    firstName: {
      required: helpers.withMessage('First name is required', required),
      maxLength: helpers.withMessage('First name must be less than 50 characters', maxLength(50))
    },
    lastName: {
      required: helpers.withMessage('Last name is required', required),
      maxLength: helpers.withMessage('Last name must be less than 50 characters', maxLength(50))
    },
    address: {
      required: helpers.withMessage('Address is required', required),
      maxLength: helpers.withMessage('Address must be less than 255 characters', maxLength(255))
    },
    city: {
      required: helpers.withMessage('City is required', required),
      maxLength: helpers.withMessage('City must be less than 255 characters', maxLength(255))
    },
    zipcode: {
      required: helpers.withMessage('Zipcode is required', required),
      maxLength: helpers.withMessage('Zipcode must be less than 10 characters', maxLength(10)),
    },
    plainPassword: {
      required: helpers.withMessage('Password is required', required),
      minLength: helpers.withMessage('Password must be at least 6 characters', minLength(6)),
      maxLength: helpers.withMessage('Password must be less than 255 characters', maxLength(255)),
      sameAs: helpers.withMessage('Password and password confirmation do not match', sameAs(confirmPlainPassword)),
    },
  };
});

const formData = ref<User>({
  id: props.user ? props.user.id : null,
  email: props.user ? props.user.email : null,
  firstName: props.user ? props.user.firstName : null,
  lastName: props.user ? props.user.lastName : null,
  address: props.user ? props.user.address : null,
  city: props.user ? props.user.city : null,
  zipcode: props.user ? props.user.zipcode : null,
  plainPassword: null,
});

const v$ = useVuelidate(rules, formData);

const submitUser = async () => {
  const result = await v$.value.$validate();
  if (!result) {
    return;
  }

  console.log(formData.value)

  axios.post('/api/user', formData.value)
    .then((response) => {
      console.log(response);
      Swal.fire({
        title: 'Success!',
        text: 'Your account has been created.',
        icon: 'success',
        confirmButtonText: 'Nice!',
      }).then(() => {
        window.location.href = '/';
      });
    })
    .catch((error) => {
      console.log(error);
    });
};
</script>

<template>
  <form @submit.prevent="submitUser" class="mb-3">

    <!-- Email Input -->
    <div class="mb-3">
      <div class="form-floating">
        <input v-model="v$.email.$model" :class="{'border-danger' : formErrors.email, 'border-success' : formOK.email}"
               type="text" class="form-control"
               id="email" aria-describedby="emailHelp"
               placeholder="Email">
        <label for="email">Email</label>
      </div>
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else. 😏</div>
      <span v-for="error in v$.email.$errors" :key="error.$uid" class="text-danger  ">{{ error.$message }}</span>
    </div>

    <!-- First Name and Last Name Inputs -->
    <div class="d-flex flex-row gap-3 mb-3">
      <div class="flex-grow-1">
        <div class="form-floating">
          <input v-model="formData.firstName"
                 :class="{'border-danger' : formErrors.firstName, 'border-success' : formOK.firstName}" type="text"
                 class="form-control" id="firstName" placeholder="First Name">
          <label for="firstName">First Name</label>
        </div>
        <span v-for="error in v$.firstName.$errors" :key="error.$uid" class="text-danger  ">{{
            error.$message
          }}</span>
      </div>
      <div class="flex-grow-1">
        <div class="form-floating">
          <input v-model="formData.lastName"
                 :class="{'border-danger' : formErrors.lastName, 'border-success' : formOK.lastName}" type="text"
                 class="form-control" id="lastName" placeholder="Last Name">
          <label for="lastName">Last Name</label>
        </div>
        <span v-for="error in v$.lastName.$errors" :key="error.$uid" class="text-danger ">{{
            error.$message
          }}</span>
      </div>
    </div>

    <!-- Address Input -->
    <div class="mb-3">
      <div class="form-floating">
        <input v-model="formData.address"
               :class="{'border-danger' : formErrors.address, 'border-success' : formOK.address}" type="text"
               class="form-control" id="address" placeholder="Address">
        <label for="address">Address</label>
      </div>
      <span v-for="error in v$.address.$errors" :key="error.$uid" class="text-danger  ">{{ error.$message }}</span>
    </div>

    <!-- City and Zipcode Inputs -->
    <div class="d-flex flex-row gap-3 mb-3">
      <div class="flex-grow-1">
        <div class="form-floating">
          <input v-model="formData.city" :class="{'border-danger' : formErrors.city, 'border-success' : formOK.city}"
                 type="text" class="form-control"
                 id="city" placeholder="City">
          <label for="city">City</label>
        </div>
        <span v-for="error in v$.city.$errors" :key="error.$uid" class="text-danger ">{{ error.$message }}</span>
      </div>
      <div class="flex-grow-1">
        <div class="form-floating">
          <input v-model="formData.zipcode"
                 :class="{'border-danger' : formErrors.zipcode, 'border-success' : formOK.zipcode}" type="text"
                 class="form-control" id="zipcode" placeholder="Zipcode">
          <label for="zipcode">Zipcode</label>
        </div>
        <span v-for="error in v$.zipcode.$errors" :key="error.$uid" class="text-danger ">{{ error.$message }}</span>
      </div>
    </div>

    <!-- Password Inputs with Floating Labels -->
    <div class="mb-3">
      <div class="form-floating">
        <input v-model="formData.plainPassword"
               :class="{'border-danger' : formErrors.plainPassword, 'border-success' : formOK.plainPassword }"
               type="password"
               class="form-control" id="password"
               placeholder="Password">
        <label for="password">Password</label>
      </div>
      <span v-for="error in v$.plainPassword.$errors" :key="error.$uid" class="text-danger">{{
          error.$message
        }}<br></span>
    </div>

    <div class="mb-3">
      <div class="form-floating">
        <input v-model="confirmPlainPassword"
               :class="{'border-danger' : formErrors.plainPassword, 'border-success' : formOK.plainPassword}"
               type="password"
               class="form-control" id="passwordConfirmation"
               placeholder="Confirm Password">
        <label for="passwordConfirmation">Confirm Password</label>
      </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">{{ props.buttonText }}</button>
  </form>
</template>

<style scoped>
/* Add any additional styling if needed */
</style>
