<script setup lang="ts">
import { ref } from "vue";

const currentPage = ref(1);
const totalPage = ref(5);
const filterSearch = ref("");
const filterShown = ref(5);
const filterTotal = ref(25);
</script>

<template>
  <span>Product List Paginated View</span>
  <!-- <PaginatedView
      :loading="false"
      :filter="{
        changeSearch: (search) => {},
        search: filterSearch,
        shown: filterShown,
        total: filterTotal,
      }"
      :pagination="{
        changePage: (page) => {
          currentPage = page;
        },
        current: currentPage,
        total: totalPage,
      }"
    >
      <ProductCardList />
    </PaginatedView> -->
</template>
