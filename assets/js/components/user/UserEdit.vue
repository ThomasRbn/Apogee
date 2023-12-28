<script setup lang="ts">

import {User} from "@js/types/types";
import {PropType} from "vue";
import UserForm from "@js/components/user/UserForm.vue";

const props = defineProps({
  user: {
    type: Object as PropType<User>,
    required: false,
  },
});
</script>

<template>
  <div class="container mt-4">
    <h1 class="text-center">Change your information</h1>
    <UserForm button-text="Update user" :user="props.user"/>
  </div>
</template>