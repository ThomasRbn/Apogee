<script setup lang="ts">

import {computed} from "vue";

const props = defineProps({
  perPage: {
    type: Number,
    required: true,
  },
  currentPage: {
    type: Number,
    required: true,
  },
  lastPage: {
    type: Number,
    required: true,
  },
  onChangePage: {
    type: Function,
    required: true,
  },
});

const pages = computed(() => {
  const pages = [];
  for (let i = 1; i <= props.lastPage; i++) {
    pages.push(i);
  }
  return pages;
});

</script>

<template>
  <div class="d-flex justify-content-center">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link" @click="props.onChangePage(props.perPage, 1)">First</a>
      </li>
      <li v-for="page in pages" :key="page" class="page-item" :class="{ 'active': page === props.currentPage }">
        <a class="page-link" @click="props.onChangePage(props.perPage, page)">{{ page }}</a>
      </li>
      <li class="page-item">
        <a class="page-link" @click="props.onChangePage(props.perPage, props.lastPage)">Last</a>
      </li>
    </ul>
  </div>
</template>


<style scoped>

</style>